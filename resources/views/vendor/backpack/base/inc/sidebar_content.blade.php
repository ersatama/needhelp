{{-- This file is used to store sidebar items, inside the Backpack admin panel --}}


@if (backpack_user()->role === 'admin')
    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i>  Статистика </a></li>

    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('ip') }}"><i class="nav-icon las la-shield-alt"></i> IP адреса</a></li>

    <li class="nav-title">Основное</li>

    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('notification-global') }}"><i class="nav-icon lar la-bell"></i> Уведомления</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('admin') }}"><i class="nav-icon la la-group"></i> Администраторы</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('moderator') }}"><i class="nav-icon la la-group"></i> Модераторы</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-group"></i> Пользователи</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('lawyer') }}"><i class="nav-icon la la-group"></i> Юристы</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('question') }}"><i class="nav-icon las la-bell"></i> Вопросы</a></li>

    <li class="nav-title">Местоположение</li>

    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('country') }}"><i class="nav-icon las la-globe"></i> Страны</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('region') }}"><i class="nav-icon las la-globe-americas"></i> Области</a></li>

    <li class="nav-title">Дополнительно</li>

    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('language') }}"><i class="nav-icon las la-language"></i> Языки</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('payment') }}"><i class="nav-icon las la-coins"></i> Платежи</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('price') }}"><i class="nav-icon las la-money-bill-wave"></i> Цены</a></li>
@elseif (backpack_user()->role === 'moderator')
    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('question') }}"><i class="nav-icon la la-question"></i> Вопросы</a></li>
@else
    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i>  Статистика </a></li>
    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('question') }}"><i class="nav-icon la la-question"></i> Вопросы</a></li>
@endif
