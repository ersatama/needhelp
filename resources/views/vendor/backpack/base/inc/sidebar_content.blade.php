{{-- This file is used to store sidebar items, inside the Backpack admin panel --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<li class="nav-title">Местоположение</li>

<li class="nav-item"><a class="nav-link" href="{{ backpack_url('country') }}"><i class="nav-icon las la-globe"></i> Страны</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('region') }}"><i class="nav-icon las la-globe-americas"></i> Регионы</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('city') }}"><i class="nav-icon las la-globe-africa"></i> Города</a></li>

<li class="nav-title">Основное</li>

<li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-group"></i> Пользователи</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('notification') }}"><i class="nav-icon las la-bell"></i> Уведомлении</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('notification-history') }}"><i class="nav-icon las la-bell"></i> История уведомлении</a></li>

<li class="nav-item"><a class="nav-link" href="{{ backpack_url('request') }}"><i class="nav-icon las la-arrow-circle-right"></i> Запросы</a></li>
