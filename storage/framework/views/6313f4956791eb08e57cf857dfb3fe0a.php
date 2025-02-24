<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo e(getSetting('app_name_ar')); ?> | الرئيسية</title>
    <link href="<?php echo e(assetUrl('css/global.css', 'landing-assets')); ?>" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo e(assetUrl('img/favicon-2.ico')); ?>">

</head>

<body class="rtl">
    <!-------------Header---------->
    <header class="header">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
                <div class="logo"><a href="#">
                        <img style=" width: 105px; height: 56px;" src="<?php echo e(getSettingMedia('app_logo')); ?>"
                            alt="logo" /></a>
                </div>
                <nav class="nav-bar">
                    <ul>
                        <li><a href="#about">عن الاعتكاف</a></li>
                        <li><a href="#services">الخدمات</a></li>
                        <li><a href="#steps">خطوات التقديم</a></li>
                        <li><a href="#faq">الاسئلة الشائعة</a></li>
                    </ul>
                </nav>
                <a href="<?php echo e(route('login')); ?>" class="cus-btn">الدخول كموظف</a>
            </div>
        </div>
    </header>
    <!-------------Banner---------->
    <main>
        <section class="home-banner" id="about">
            <div class="container">
                <div class="row flex-row-reverse align-items-center">
                    <div class="col-md-6" data-aos="fade-right">
                        <div class="banner-img">
                            <img src="<?php echo e(assetUrl('images/banner.png', 'landing-assets')); ?>" alt="" />
                        </div>
                    </div>
                    <div class="col-md-6" data-aos="fade-left">
                        <h1>خطوتك الأولى نحو اعتكاف مميز في الحرمين الشريفين</h1>
                        <p>قدّم طلب اعتكافك بسهولة واستمتع بخدمات متكاملة مصممة لجعل رحلتك الروحانية أكثر راحة</p>
                        <a href="#" class="com-ntn"><img src="<?php echo e(assetUrl('images/code.svg', 'landing-assets')); ?>"
                                alt="" />
                            حمّل
                            التطبيق</a>
                    </div>
                </div>
            </div>

        </section>
        <section class="sec" id="services">
            <div class="container">
                <span class="sub-hed">الخدمات المقدمة</span>
                <h2>خدمات مميزة لتجربة اعتكاف مريحة</h2>
                <div class="row">
                    <div class="col-md-4" data-aos="flip-left">
                        <div class="col-box">
                            <img src="<?php echo e(assetUrl('images/icon-1.svg', 'landing-assets')); ?>" alt="" />
                            <h3>توفير مواد العبادة</h3>
                            <p>نسخ من المصاحف، كتيبات أدعية، وسجاد للصلاة.</p>
                            <span class="bx-bg"><img src="<?php echo e(assetUrl('images/card-bg.svg', 'landing-assets')); ?>"
                                    alt="" /></span>
                        </div>
                    </div>
                    <div class="col-md-4" data-aos="flip-left">
                        <div class="col-box">
                            <img src="<?php echo e(assetUrl('images/icon-2.svg', 'landing-assets')); ?>" alt="" />
                            <h3>أماكن مخصصة للاعتكاف</h3>
                            <p>مناطق هادئة ومجهزة بجميع وسائل الراحة لضمان تركيزك في العبادة.</p>
                            <span class="bx-bg"><img src="<?php echo e(assetUrl('images/card-bg.svg', 'landing-assets')); ?>"
                                    alt="" /></span>
                        </div>
                    </div>
                    <div class="col-md-4" data-aos="flip-left">
                        <div class="col-box">
                            <img src="<?php echo e(assetUrl('images/icon-3.svg', 'landing-assets')); ?>" alt="" />
                            <h3>إرشادات ومساعدة مستمرة</h3>
                            <p>فريق دعم متوفر على مدار الساعة للإجابة عن استفساراتك وتقديم التوجيه اللازم</p>
                            <span class="bx-bg"><img src="<?php echo e(assetUrl('images/card-bg.svg', 'landing-assets')); ?>"
                                    alt="" /></span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="sec bg-light" id="steps">
            <div class="container">
                <div class="row flex-row-reverse align-items-center">
                    <div class="col-md-6" data-aos="fade-right">
                        <img src="<?php echo e(assetUrl('images/login-img.jpg', 'landing-assets')); ?>" alt="" />
                    </div>
                    <div class="col-md-6" data-aos="fade-left">
                        <div class="sec-con">
                            <span class="sub-hed">خدمات لتجربة مثالية</span>
                            <h2>تسجيل الحساب<br> بسهولة لجميع الفئات</h2>
                            <p class="sec-txt">يوفر التطبيق خيارات تسجيل مرنة تناسب الجميع، سواء كنت مواطنًا
                                سعوديًا/مقيمًا داخل المملكة، زائرًا دوليًا، أو مواطنًا خليجيًا. يتم التسجيل باستخدام
                                الهوية الوطنية أو الإقامة، مع دعم تسجيل الدخول عبر النفاذ الوطني الموحد لتوفير أمان
                                وسلاسة في الاستخدام.</p>
                        </div>
                    </div>

                </div>
                <div class="row align-items-center mt-5">
                    <div class="col-md-6" data-aos="fade-left">
                        <img src="<?php echo e(assetUrl('images/main-img.jpg', 'landing-assets')); ?>" alt="">
                    </div>
                    <div class="col-md-6" data-aos="fade-right">
                        <div class="sec-con">
                            <span class="sub-hed">كل ما تحتاجه لاعتكاف مريح</span>
                            <h2>الشاشة الرئيسية</h2>
                            <ul class="sec-list">
                                <li><strong>إرسال طلب الاعتكاف: </strong>إمكانية تقديم طلب الاعتكاف بسهولة من خلال واجهة
                                    مخصصة.</li>
                                <li><strong>الخدمات المقدمة: </strong>تشمل تسجيل الدخول والخروج بسهولة عبر بوابات
                                    الحرمين، والتواصل الفوري مع الدعم من خلال اللايف شات.</li>
                                <li><strong>طلب الخدمات: </strong>مثل الطعام، الشراب، أدوات النظافة، ومساعدات أخرى من
                                    إدارة الاعتكاف.</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row flex-row-reverse align-items-center mt-5">
                    <div class="col-md-6" data-aos="fade-right">
                        <img src="<?php echo e(assetUrl('images/send-request-img.jpg', 'landing-assets')); ?>" alt="" />
                    </div>
                    <div class="col-md-6" data-aos="fade-left">
                        <div class="sec-con">
                            <span class="sub-hed">خطوات تقديم الطلب</span>
                            <h2>إرسال طلب الاعتكاف</h2>
                            <ul class="sec-list-num">
                                <li><span class="li-num">1</span><strong>فتح التطبيق وتسجيل الدخول: </strong>افتح
                                    التطبيق وسجل الدخول .</li>

                                <li><span class="li-num">2</span><strong>اختيار الحرم والموقع: </strong> اختر الحرم
                                    الذي ترغب في الاعتكاف فيه وحدد موقعك داخل الحرم أو ابحث عنه على الخريطة.</li>

                                <li><span class="li-num">3</span><strong>حدد مدة الاعتكاف وتواريخ البدء والنهاية:
                                    </strong>حدد مدة الاعتكاف، وتاريخ البدء والنهاية، وأدخل بياناتك الشخصية بدقة.</li>

                                <li><span class="li-num">4</span><strong>إرسال الطلب وانتظار الموافقة :</strong>قدم
                                    طلبك بعد التأكد من المعلومات، وستتلقى إشعارًا بحالة طلبك.</li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <section class="sec" id="faq">
            <div class="container">
                <div class="faq-sec bg-light" data-aos="fade-up">
                    <h2>الأسئلة الشائعة</h2>

                    <ul class="accordion-list">
                        <li class="active">
                            <h3><span class="li-num">1</span> كيف يمكنني تقديم طلب اعتكاف؟ <span
                                    class="trig"></span></h3>
                            <div class="answer">
                                <p>تتيح لك هذه الميزة تقديم طلب اعتكافك بسهولة، من خلال ملء استمارة مخصصة تضم معلوماتك
                                    الشخصية وتفضيلاتك مثل مدة الاعتكاف والموقع المفضل. بعد تقديم الطلب، يتم تصنيفه
                                    تلقائيًا بناءً على المعايير المحددة مثل الأولوية والتوافر. ستتلقى إشعارًا فور قبول
                                    طلبك أو رفضه مع تفاصيل الترشيح والموقع المخصص لك.</p>

                            </div>
                        </li>
                        <li>
                            <h3><span class="li-num">2</span> ما هي الخدمات المتوفرة داخل التطبيق؟ <span
                                    class="trig"></span></h3>
                            <div class="answer">
                                <p>تتيح لك هذه الميزة تقديم طلب اعتكافك بسهولة، من خلال ملء استمارة مخصصة تضم معلوماتك
                                    الشخصية وتفضيلاتك مثل مدة الاعتكاف والموقع المفضل. بعد تقديم الطلب، يتم تصنيفه
                                    تلقائيًا بناءً على المعايير المحددة مثل الأولوية والتوافر. ستتلقى إشعارًا فور قبول
                                    طلبك أو رفضه مع تفاصيل الترشيح والموقع المخصص لك.</p>
                            </div>
                        </li>
                        <li>
                            <h3><span class="li-num">3</span> هل يمكنني تعديل معلوماتي الشخصية؟ <span
                                    class="trig"></span></h3>
                            <div class="answer">
                                <p>تتيح لك هذه الميزة تقديم طلب اعتكافك بسهولة، من خلال ملء استمارة مخصصة تضم معلوماتك
                                    الشخصية وتفضيلاتك مثل مدة الاعتكاف والموقع المفضل. بعد تقديم الطلب، يتم تصنيفه
                                    تلقائيًا بناءً على المعايير المحددة مثل الأولوية والتوافر. ستتلقى إشعارًا فور قبول
                                    طلبك أو رفضه مع تفاصيل الترشيح والموقع المخصص لك.</p>
                            </div>
                        </li>
                        <li>
                            <h3><span class="li-num">4</span> كيف يمكنني الوصول إلى مكان اعتكافي بسهولة؟<span
                                    class="trig"></span></h3>
                            <div class="answer">
                                <p>تتيح لك هذه الميزة تقديم طلب اعتكافك بسهولة، من خلال ملء استمارة مخصصة تضم معلوماتك
                                    الشخصية وتفضيلاتك مثل مدة الاعتكاف والموقع المفضل. بعد تقديم الطلب، يتم تصنيفه
                                    تلقائيًا بناءً على المعايير المحددة مثل الأولوية والتوافر. ستتلقى إشعارًا فور قبول
                                    طلبك أو رفضه مع تفاصيل الترشيح والموقع المخصص لك.</p>
                            </div>
                        </li>
                        <li>
                            <h3><span class="li-num">5</span> كيف أرسل شكوى أو اقتراح؟ <span class="trig"></span>
                            </h3>
                            <div class="answer">
                                <p>تتيح لك هذه الميزة تقديم طلب اعتكافك بسهولة، من خلال ملء استمارة مخصصة تضم معلوماتك
                                    الشخصية وتفضيلاتك مثل مدة الاعتكاف والموقع المفضل. بعد تقديم الطلب، يتم تصنيفه
                                    تلقائيًا بناءً على المعايير المحددة مثل الأولوية والتوافر. ستتلقى إشعارًا فور قبول
                                    طلبك أو رفضه مع تفاصيل الترشيح والموقع المخصص لك.</p>

                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </section>

    </main>




    <footer class="footer">
        <div class="container">
            <div class="d-flex align-items-center flex-wrap justify-content-between">
                <div class="logo"><a href="#"><img src="<?php echo e(getSettingMedia('app_logo')); ?>"
                            style=" width: 105px; height: 56px;" alt="logo" /></a>
                </div>
                <nav class="nav-bar">
                    <ul>
                        <li><a href="#about">عن الاعتكاف</a></li>
                        <li><a href="#services">الخدمات</a></li>
                        <li><a href="#steps">خطوات التقديم</a></li>
                        <li><a href="#faq">الاسئلة الشائعة</a></li>
                    </ul>
                </nav>
                <a href="#" class="com-ntn"><img src="<?php echo e(assetUrl('images/code.svg', 'landing-assets')); ?>"
                        alt="" />
                    حمّل
                    التطبيق</a>
            </div>
            <p class="text-center">&copy; 2025 جميع الحقوق محفوظة لتطبيق الاعتكاف.</p>
        </div>
    </footer>
    <script src="<?php echo e(assetUrl('js/jquery-3.2.1.min.js')); ?>"></script>
    <script src="<?php echo e(assetUrl('js/popper.min.js', 'landing-assets')); ?>"></script>
    <script src="<?php echo e(assetUrl('js/bootstrap.min.js', 'landing-assets')); ?>"></script>
    <script src="https://unpkg.com/aos@2.3.0/dist/aos.js"></script>

    <script>
        AOS.init({
            duration: 1200,
        })

        $(document).ready(function() {
            //$('.accordion-list > li > .answer').hide();

            $('.accordion-list > li').click(function() {
                if ($(this).hasClass("active")) {
                    $(this).removeClass("active").find(".answer").slideUp();
                } else {
                    $(".accordion-list > li.active .answer").slideUp();
                    $(".accordion-list > li.active").removeClass("active");
                    $(this).addClass("active").find(".answer").slideDown();
                }
                return false;
            });

        });
    </script>
</body>

</html>
<?php /**PATH C:\Users\mahmo\Herd\eatikaf\resources\views/landing/index.blade.php ENDPATH**/ ?>