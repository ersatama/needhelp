<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Heed Help</title>
    <link rel="stylesheet" href="/css/normalize.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/landing.css">
</head>
<body>
<section class="start">
    <div class="container">
        <img class="start__logotype" alt="Логотип"  src="/src/logotype.svg" loading="lazy" />
        <h1 class="start__title">
            <span class="start__title_name">Need Help</span>
            Юридическая помощь в режиме онлайн 24/7
        </h1>
        <ul class="app-download">
            <li>
                <a href="https://apps.apple.com/us/app/needhelp-legal-assistance/id1663667463">
                    <img src="/src/appstore.svg" alt="download-ios" class="app-download__image" loading="lazy">
                </a>
            </li>
            <li>
                <a href="https://play.google.com/store/apps/details?id=kz.needhelp">
                    <img src="/src/googlestore.svg" alt="download-android" class="app-download__image" loading="lazy">
                </a>
            </li>
            <li>
                <a href="#">
                    <img src="/src/onelinkto_kury62.svg" alt="download-qr" class="app-download__image" loading="lazy">
                </a>
            </li>
        </ul>
        <picture class="start__main-img">
            <source srcset="/src/main_image.webp" type="image/webp" />
            <img src="/src/main_image.png" alt="главная" loading="lazy" />
        </picture>
    </div>
</section>
<section class="advantages">
    <h2 class="advantages__title">Преимущества</h2>
    <ul class="advantages__list">
        <li class="advantages__item">
            <img src="/src/a1.svg" alt="" class="advantages__item-image" loading="lazy">
            Быстрые ответы на ваши вопросы
        </li>
        <li class="advantages__item">
            <img src="/src/a2.svg" alt="" class="advantages__item-image" loading="lazy">
            Гарантия конфиденциальности
        </li>
        <li class="advantages__item">
            <img src="/src/a3.svg" alt="" class="advantages__item-image" loading="lazy">
            Качество сервиса и профессионализм
        </li>
        <li class="advantages__item">
            <img src="/src/a4.svg" alt="" class="advantages__item-image" loading="lazy">
            Актуальная нормативно-правовая база
        </li>
    </ul>
</section>
<section class="description">
    <div class="container">
        <picture class="description__main-img">
            <source srcset="/src/secondary_image.webp" type="image/webp" />
            <img src="/src/secondary_image.png" alt="описание" loading="lazy" />
        </picture>

        <h2 class="description__title">Юрист который всегда с тобой 24/7</h2>
        <p class="description__content">Need Help - это команда юристов с актуальной юридической базой законодательства, готовая оказать быструю профессиональную помощь по любым правовым вопросам</p>
        <ul class="app-download">
            <li>
                <a href="https://apps.apple.com/us/app/needhelp-legal-assistance/id1663667463">
                    <img src="/src/appstore.svg" alt="download-ios" class="app-download__image" loading="lazy">
                </a>
            </li>
            <li>
                <a href="https://play.google.com/store/apps/details?id=kz.needhelp">
                    <img src="/src/googlestore.svg" alt="download-android" class="app-download__image" loading="lazy">
                </a>
            </li>
            <li>
                <a href="#">
                    <img src="/src/onelinkto_kury62.svg" alt="download-qr" class="app-download__image" loading="lazy">
                </a>
            </li>
        </ul>
    </div>
</section>
<footer class="footer">
    <div class="container">
        <ul class="social">
            <li>
                <a href="#">
                    <img src="/src/twitter.svg" alt="twitter" class="social__link" loading="lazy">
                </a>
            </li>
            <li>
                <a href="#">
                    <img src="/src/facebook.svg" alt="facebook" class="social__link" loading="lazy">
                </a>
            </li>
            <li>
                <a href="#">
                    <img src="/src/instagram.svg" alt="instagram" class="social__link" loading="lazy">
                </a>
            </li>
            <li>
                <a href="#">
                    <img src="/src/github.svg" alt="github" class="social__link" loading="lazy">
                </a>
            </li>
        </ul>
        <ul class="links">
            <li>
                <a href="https://needhelp.kz/privacy" class="links__item">Политика конфиденциальности</a>
            </li>
            <li>
                <a href="https://needhelp.kz/terms" class="links__item">Условия использования</a>
            </li>
        </ul>
        <p class="copyright">&#169; Copyright 2022, All Rights Reserved</p>
    </div>
</footer>
</body>
</html>
