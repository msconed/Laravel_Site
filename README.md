<h1>Добавлено:</h1>

<ul>
    <li>Авторизация и регистрация через модальное окно и HTMX</li>
    <li>API</li>
    <li>Простенький форум:
    <ul><li>Категории, подкатегории, топики и их создание, просмотр содержимого топика, комментарии в топике.</li>
        <li>Категории, подкатегории</li>
    </ul>
    </li>
    <li>Переключение 2 языков(en, ru), устанавливается через middleware-group(перед каждым запросом) в сессии и(если залогинен) в БД(User).</li>
</ul>



<h2>API:</h2>

<ul>
<p>Обращение к API:</p>
<li>Проверить зарегистрирован ли такой-то никнейм: [POST] http://127.0.0.1:8000/api/?mode=username_exists&query={nickname}</li>
<li>Проверить зарегистрирован ли такой-то email: [POST] http://127.0.0.1:8000/api/?mode=email_exists&email={email@email.com}</li>
<li>Создание пользователя: [POST] http://127.0.0.1:8000/api/?mode=create_user&username={username}&password={password}&email={email@email.com}</li>
</ul>
