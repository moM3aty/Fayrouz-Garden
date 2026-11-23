<?php
/**
 * نظام رفع الصور الآمن
 */
declare(strict_types=1);

require_once __DIR__ . '/functions.php';

/**
 * رفع صورة بشكل آمن
 * @return array{ok:bool,path?:string,error?:string,skip?:bool}
 */
function handleImageUpload(array $file, string $prefix = 'img', ?string $oldPath = null): array
{
    // لا يوجد ملف مرفوع
    if (!isset($file['tmp_name']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return ['ok' => false, 'skip' => true];
    }
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['ok' => false, 'error' => 'فشل رفع الملف. رمز الخطأ: ' . $file['error']];
    }
    if ($file['size'] > MAX_UPLOAD_MB * 1024 * 1024) {
        return ['ok' => false, 'error' => 'حجم الصورة يجب أن يكون أقل من ' . MAX_UPLOAD_MB . 'MB.'];
    }

    // فحص MIME الفعلي (أمان ضد spoofing)
    if (!class_exists('finfo')) {
        return ['ok' => false, 'error' => 'إضافة fileinfo غير مفعّلة على السيرفر.'];
    }
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime  = $finfo->file($file['tmp_name']);

    $allowedMimes = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
        'image/gif'  => 'gif',
    ];
    if (!isset($allowedMimes[$mime])) {
        return ['ok' => false, 'error' => 'نوع الصورة غير مدعوم (JPG, PNG, WEBP, GIF فقط).'];
    }

    // فحص أن الملف صورة فعلية
    if (getimagesize($file['tmp_name']) === false) {
        return ['ok' => false, 'error' => 'الملف ليس صورة صالحة.'];
    }

    $ext      = $allowedMimes[$mime];
    $filename = $prefix . '_' . date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . '.' . $ext;

    $dir = UPLOADS_PATH;
    if (!is_dir($dir) && !mkdir($dir, 0755, true) && !is_dir($dir)) {
        return ['ok' => false, 'error' => 'تعذر إنشاء مجلد الرفع.'];
    }
    if (!is_writable($dir)) {
        return ['ok' => false, 'error' => 'مجلد الرفع غير قابل للكتابة.'];
    }

    $dest = rtrim($dir, '/') . '/' . $filename;
    if (!move_uploaded_file($file['tmp_name'], $dest)) {
        return ['ok' => false, 'error' => 'فشل حفظ الملف على السيرفر.'];
    }
    @chmod($dest, 0644);

    // حذف الصورة القديمة إذا كانت داخل مجلد الرفع
    if ($oldPath && str_starts_with($oldPath, UPLOADS_URL . '/')) {
        $oldFile = rtrim(UPLOADS_PATH, '/') . '/' . basename($oldPath);
        if (is_file($oldFile)) @unlink($oldFile);
    }

    return ['ok' => true, 'path' => UPLOADS_URL . '/' . $filename];
}

/**
 * حذف صورة من مجلد الرفع (إن كانت داخله)
 */
function deleteUploadedImage(?string $path): void
{
    if (!$path || !str_starts_with($path, UPLOADS_URL . '/')) return;
    $file = rtrim(UPLOADS_PATH, '/') . '/' . basename($path);
    if (is_file($file)) @unlink($file);
}

/**
 * تحويل مسار صورة لعرضها في لوحة التحكم (prepend ../ للصور المحلية)
 */
function adminImg(?string $path): string
{
    if (!$path) return '';
    if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '/')) {
        return $path;
    }
    return '../' . $path;
}