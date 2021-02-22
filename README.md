## **Экзаменационный проект по MVC**

### C использованием MVC-фреймворка Laravel 8.x на PHP.

#### Задание - Второй вариант.

Создать веб-проект «Инструкции для техники». Очень часто возникает необходимость найти потерянную инструкцию. Например, для холодильника или стиральной машины.
Основная задача проекта предоставить удобный интерфейс для поиска, чтения и размещения инструкций для техники

##### **Проект должен позволять пользователю:**

■ Искать инструкцию по текстовому шаблону. Пользователь вводит название технического прибора для поиска.

■ Читать найденную инструкцию.

■ Скачивать найденную инструкцию.

■ Пожаловаться на инструкцию администрации проекта. При жалобе пользователь должен указать в чём суть жалобы.

■ Зарегистрироваться на портале. Регистрация является обязательным для загрузки инструкции. Регистрация должна быть реализована через собственную форму веб-проекта. При входе и регистрации кроме пароля и логина, необходимо предусмотреть защиту по CAPTCHA.

■ Загрузить инструкцию на портал. При загрузке необходимо дать описание инструкции. Загруженная инструкция станет доступной для пользователей только после утверждения администрацией проекта.

##### **Проект должен иметь административную часть. Она должна позволять:**

■ Добавлять/удалять инструкции.

■ Одобрять инструкции, загруженные пользователем.

■ Добавлять/удалять/блокировать/разблокировать пользователей.


==============================================================

##### **План базы данных:**

instructions: id, title, description, file_name, status, author_id, created_at, updated_at

instruction_complaints: id, user_id, instruction_id, instruction_сomplaint_status_id, description, created_at, updated_at

instruction_complaint_statuses: id, title, created_at, updated_at

users: id, name, block, email, email_verified_at, password, remember_token, created_at, updated_at, blocked_at

user_role: id, user_id, role_id, created_at, updated_at

user_roles: id, title, created_at, updated_at

password_resets: email, token, created_at

