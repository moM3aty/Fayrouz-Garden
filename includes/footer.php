<footer class="footer-section">
<div class="container">
<div class="row g-5">
<div class="col-lg-4 col-md-6">
<div class="footer-logo d-flex align-items-center gap-3 mb-3">
<img alt="<?= e($siteName) ?>" onerror="this.style.display='none'" src="<?= e($logo) ?>"/>
<div>
<h4 class="fw-bold text-white mb-0"><?= e($siteName) ?></h4>
<small class="text-success fw-bold">أبو محمد لتنسيق الحدائق</small>
</div>
</div>
<p class="text-secondary mb-4" style="line-height: 1.9;">
            رواد تصميم وتنسيق الحدائق المنزلية، شبكات الري الذكية، الشلالات، البرجولات، وزهور الفل والياسمين والريحان العطرة.
          </p>
<div class="d-flex align-items-center gap-3">
<a class="btn btn-outline-success btn-sm rounded-pill text-white fw-bold px-3" href="tel:<?= e($phone) ?>">
<i class="fa-solid fa-phone me-1"></i> <?= e($phone) ?>
            </a>
<a class="btn btn-success btn-sm rounded-pill text-white fw-bold px-3" href="https://wa.me/<?= e($whatsapp) ?>" rel="noopener noreferrer" target="_blank">
<i class="fa-brands fa-whatsapp me-1"></i> واتساب
            </a>
</div>
</div>
<div class="col-lg-2 col-md-6">
<h5 class="fw-bold text-white mb-3">روابط سريعة</h5>
<ul class="list-unstyled">
<li><a class="footer-link" href="#hero">الرئيسية</a></li>
<li><a class="footer-link" href="#about">من نحن</a></li>
<li><a class="footer-link" href="#services">خدماتنا</a></li>
<li><a class="footer-link" href="#garden-interactive">الزهرة والشجرة</a></li>
<li><a class="footer-link" href="#portfolio">معرض الأعمال</a></li>
<li><a class="footer-link" href="#project-photos">صور المشاريع</a></li>
</ul>
</div>
<div class="col-lg-3 col-md-6">
<h5 class="fw-bold text-white mb-3">خدمات اللاندسكيب</h5>
<ul class="list-unstyled">
<li><a class="footer-link" href="#water-features">الشلالات والنوافير الجدارية</a></li>
<li><a class="footer-link" href="#smart-irrigation">شبكات الري الأوتوماتيكية</a></li>
<li><a class="footer-link" href="#pergolas">المظلات والبرجولات الخشبية</a></li>
<li><a class="footer-link" href="#fragrant-haven">أركان الفل والياسمين والريحان</a></li>
</ul>
</div>
<div class="col-lg-3 col-md-6">
<h5 class="fw-bold text-white mb-3">الاتصال المباشر</h5>
<p class="text-secondary small mb-2"><i class="fa-solid fa-location-dot text-success me-2"></i> الرياض: الملقا، النرجس، الياسمين، القيروان، العارض، الصحافة</p>
<p class="text-secondary small mb-2"><i class="fa-solid fa-phone text-success me-2"></i> <a class="text-white fw-bold" href="tel:<?= e($phone) ?>"><?= e($phone) ?></a></p>
<p class="text-secondary small mb-3"><i class="fa-brands fa-whatsapp text-success me-2"></i> <a class="text-white fw-bold" href="https://wa.me/<?= e($whatsapp) ?>" rel="noopener noreferrer" target="_blank"><?= e($phone) ?></a></p>
<div class="p-3 rounded-3" style="background: rgba(255,255,255,0.06);">
<small class="text-success fw-bold d-block mb-1">تواصل واستفسار</small>
<small class="text-light">مهندس المشتل جاهز للرد على استفساراتكم على مدار اليوم.</small>
</div>
</div>
</div>
<div class="designer-credit-box">
<p class="mb-3 text-secondary">
          جميع الحقوق محفوظة © <?= e($siteName) ?> لتنسيق الحدائق المنزلية <?= e($phone) ?>
        </p>
<div>
<a class="designer-credit-link" href="https://www.facebook.com/profile.php?id=100090592885243" rel="noopener noreferrer" target="_blank">
<i class="fa-brands fa-facebook"></i> تم التصميم بواسطة GMTWEB
          </a>
</div>
</div>
</div>
</footer>
<div class="floating-contact-bar">
<a class="float-circle-btn float-wa" href="https://wa.me/<?= e($whatsapp) ?>" rel="noopener noreferrer" target="_blank" title="محادثة واتساب">
<div class="pulse-radar"></div>
<i class="fa-brands fa-whatsapp"></i>
</a>
<a class="float-circle-btn float-call" href="tel:<?= e($phone) ?>" title="اتصال هاتفي">
<div class="pulse-radar"></div>
<i class="fa-solid fa-phone-volume"></i>
</a>
<a class="float-circle-btn float-scroll-top" href="#hero" id="scrollTopBtn" title="العودة للأعلى">
<i class="fa-solid fa-arrow-up"></i>
</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function openDrawer() {
      document.getElementById('sideDrawer').classList.add('active');
      document.getElementById('drawerOverlay').classList.add('active');
      document.body.style.overflow = 'hidden';
    }

    function closeDrawer() {
      document.getElementById('sideDrawer').classList.remove('active');
      document.getElementById('drawerOverlay').classList.remove('active');
      document.body.style.overflow = '';
    }

    window.addEventListener('scroll', function() {
      const scrollBtn = document.getElementById('scrollTopBtn');
      if (window.scrollY > 400) {
        scrollBtn.classList.add('show');
      } else {
        scrollBtn.classList.remove('show');
      }
    });

    const canvas = document.getElementById('heroCanvas');
    const ctx = canvas.getContext('2d');
    let petals = [];
    const petalColors = ['#e57aa2', '#ec8093', '#1fa861', '#93dcb0', '#fde047', '#4fa9d6'];

    function resizeCanvas() {
      canvas.width = canvas.offsetWidth;
      canvas.height = canvas.offsetHeight;
    }
    window.addEventListener('resize', resizeCanvas);
    window.addEventListener('load', resizeCanvas);
    resizeCanvas();

    for (let i = 0; i < 40; i++) {
      petals.push({
        x: Math.random() * canvas.width,
        y: Math.random() * canvas.height,
        r: Math.random() * 6 + 4,
        d: Math.random() * 40,
        color: petalColors[Math.floor(Math.random() * petalColors.length)],
        tilt: Math.random() * 10 - 5,
        tiltAngleInc: (Math.random() * 0.07) + 0.03,
        tiltAngle: 0
      });
    }

    function drawPetals() {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      for (let i = 0; i < petals.length; i++) {
        let p = petals[i];
        p.tiltAngle += p.tiltAngleInc;
        p.y += (Math.cos(p.d) + 1 + p.r / 3) * 0.7;
        p.x += Math.sin(p.d) * 0.6;
        p.tilt = Math.sin(p.tiltAngle) * 12;

        if (p.x > canvas.width + 10 || p.x < -10 || p.y > canvas.height + 10) {
          petals[i].x = Math.random() * canvas.width;
          petals[i].y = -10;
        }

        ctx.beginPath();
        ctx.fillStyle = p.color;
        ctx.globalAlpha = 0.65;
        ctx.ellipse(p.x, p.y, p.r, p.r * 1.5, (p.tilt * Math.PI) / 180, 0, 2 * Math.PI);
        ctx.fill();
        ctx.globalAlpha = 1.0;
      }
      requestAnimationFrame(drawPetals);
    }
    drawPetals();

    function waterTheGarden() {
      const container = document.getElementById('dropletsContainer');
      const leaves = document.querySelectorAll('.tree-leaf-cluster');
      const status = document.getElementById('gardenStatusText');

      for (let i = 0; i < 16; i++) {
        const drop = document.createElement('div');
        drop.className = 'droplet';
        drop.style.left = (Math.random() * 80 + 10) + '%';
        drop.style.top = (Math.random() * 40) + 'px';
        drop.style.animationDelay = (Math.random() * 0.5) + 's';
        container.appendChild(drop);
        setTimeout(() => drop.remove(), 1300);
      }

      leaves.forEach((leaf, idx) => {
        leaf.style.transform = 'scale(1.15)';
        leaf.setAttribute('fill', idx % 2 === 0 ? '#1fa861' : '#4ade80');
        setTimeout(() => {
          leaf.style.transform = 'scale(1)';
          leaf.setAttribute('fill', idx % 2 === 0 ? '#147a4b' : '#16a34a');
        }, 1800);
      });

      status.innerText = 'تم سقي شجرة الفيروز بماء نقي عذب! انتعشت الأوراق وتلألأت خضاراً وجمالاً.';
      status.style.color = '#116da6';
    }

    function bloomTheFlower() {
      const flower = document.getElementById('flowerSvg');
      const status = document.getElementById('gardenStatusText');
      flower.classList.toggle('bloom-active');

      const isBloomed = flower.classList.contains('bloom-active');
      status.innerText = isBloomed ? 'تفتحت زهرة الياسمين والفل بالكامل لتفوح بأبهى روائح الربيع!' : 'عادت البتلات للهدوء الطبيعي، انقر مجدداً لتتفتح!';
      status.style.color = isBloomed ? '#e11d48' : '#147a4b';
    }

    function changeFlowerAura(type) {
      const petals = document.querySelectorAll('.flower-petal');
      const label = document.getElementById('flowerNameLabel');
      const status = document.getElementById('gardenStatusText');

      if (type === 'fol') {
        petals.forEach(p => p.setAttribute('fill', '#fffdf0'));
        document.getElementById('flowerCenter').setAttribute('fill', '#fde047');
        label.innerText = 'زهرة الفل الأبيض الناصع';
        status.innerText = 'تم اختيار نفحة الفل الأبيض البلدي، رمز النقاء والبهجة في مجالس الحديقة!';
        status.style.color = '#ca8a04';
      } else if (type === 'rayhan') {
        petals.forEach(p => p.setAttribute('fill', '#84cc16'));
        document.getElementById('flowerCenter').setAttribute('fill', '#3f6212');
        label.innerText = 'شجيرة الريحان العطري الأخضر';
        status.innerText = 'تم اختيار نفحة الريحان الأخضر الفواح، يعطر الأرجاء وينعش الأنفاس!';
        status.style.color = '#3f6212';
      }
    }

    let lbIdx = 0;
    let lbGroup = [];
    const lbItems = () => lbGroup;
    function showLightbox(i) {
      const items = lbItems();
      lbIdx = (i + items.length) % items.length;
      const img = document.getElementById('lightboxImg');
      img.src = items[lbIdx].dataset.src;
      img.alt = items[lbIdx].querySelector('img').alt;
      document.getElementById('lightboxCount').textContent = (lbIdx + 1) + ' / ' + items.length;
    }
    function openLightbox(btn) {
      lbGroup = [...btn.closest('.row').querySelectorAll('.portfolio-card')];
      showLightbox(lbGroup.indexOf(btn));
      document.getElementById('portfolioLightbox').classList.add('active');
      document.body.style.overflow = 'hidden';
    }
    function stepLightbox(d) { showLightbox(lbIdx + d); }
    document.addEventListener('keydown', e => {
      if (!document.getElementById('portfolioLightbox').classList.contains('active')) return;
      if (e.key === 'Escape') closeLightboxDirect();
      else if (e.key === 'ArrowLeft') stepLightbox(1);
      else if (e.key === 'ArrowRight') stepLightbox(-1);
    });

    function closeLightbox(e) {
      if (e.target.id === 'portfolioLightbox') {
        closeLightboxDirect();
      }
    }

    function closeLightboxDirect() {
      document.getElementById('portfolioLightbox').classList.remove('active');
      document.body.style.overflow = '';
    }

    function handleConsultSubmit(e){
      e.preventDefault();
      const val=id=>document.getElementById(id).value.trim();
      const message=['السلام عليكم مشتل الفيروز، أرغب في الاستفسار عن تنسيق حديقتي:',
        'الاسم: '+val('custName'),'الجوال: '+val('custPhone'),'المدينة أو الحي: '+val('custCity'),
        'الخدمة: '+val('custService'),'ملاحظات: '+val('custNotes')].join('\n');
      window.open('https://wa.me/<?= e($whatsapp) ?>?text='+encodeURIComponent(message),'_blank','noopener,noreferrer');
    }

    const quizState={sun:null,space:null,care:null};
    function pickQuiz(el,group,value){quizState[group]=value;el.parentElement.querySelectorAll('.quiz-chip').forEach(c=>{c.classList.remove('active');c.setAttribute('aria-pressed','false')});el.classList.add('active');el.setAttribute('aria-pressed','true')}
    function showQuizResult(){
      const box=document.getElementById('quizResult');
      if(Object.values(quizState).some(x=>!x)){box.textContent='اختر إجابة من كل مجموعة أولاً.'}
      else {
        const sun={full:'شمس كاملة',half:'نصف ظل',shade:'ظل أغلب اليوم'};
        const space={small:'أقل من 50 م²',mid:'من 50 إلى 150 م²',big:'أكثر من 150 م²'};
        const care={low:'وقت قليل للعناية',mid:'عناية أسبوعية',high:'البستنة هواية'};
        const heading=document.createElement('h4');heading.textContent='ملخص فكرتك الأولية';
        const text=document.createElement('p');text.textContent=[sun[quizState.sun],space[quizState.space],care[quizState.care]].join(' • ');
        const note=document.createElement('p');note.textContent='ناقش توزيع الجلسات والممرات ونوع النباتات والري وفق هذه الاختيارات. الملخص بداية للنقاش وليس مخطط تنفيذ أو عرض سعر.';
        box.replaceChildren(heading,text,note);
      }
      box.classList.add('show');box.tabIndex=-1;box.focus({preventScroll:true});box.scrollIntoView({behavior:'smooth',block:'center'});
    }
    function showCheckupResult(){
      const box=document.getElementById('checkupResult');
      const selected=[...document.querySelectorAll('.checkup-check:checked')].map(c=>c.parentElement.querySelector('span').textContent);
      const heading=document.createElement('h4');heading.textContent='قائمة ملاحظاتك';
      const text=document.createElement('p');text.textContent=selected.length?selected.join(' • '):'لم تحدد ملاحظات. هذا لا يثبت خلو الحديقة من المشكلات.';
      const note=document.createElement('p');note.textContent='التقط صوراً واضحة للملاحظات وحدد مكانها ووقت ظهورها لتناقشها مع فريق التنفيذ. لا يمكن تحديد السبب أو العلاج من عدد الاختيارات فقط.';
      box.replaceChildren(heading,text,note);box.classList.add('show');box.tabIndex=-1;box.focus({preventScroll:true});box.scrollIntoView({behavior:'smooth',block:'center'});
    }
  </script>
<script>
function toggleTip(el){el.classList.toggle('flipped');el.setAttribute('aria-pressed',String(el.classList.contains('flipped')))}
document.querySelectorAll('img').forEach(function(img){img.addEventListener('error',function(){if(img.id==='lightboxImg')return;img.hidden=true;const box=document.createElement('div');box.className='missing-image';box.textContent='الصورة غير مرفقة';img.after(box)})});
</script><script>document.querySelectorAll('img[onerror]').forEach(i=>{if(i.complete&&!i.naturalWidth)i.dispatchEvent(new Event('error'))});</script>
</body>
</html>