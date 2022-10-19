<?php
?>

<form method="POST" action="https://test.paycom.uz">

    <!-- Идентификатор WEB Кассы -->
    <input type="hidden" name="merchant" value="{Merchant ID}"/>

    <!-- Сумма платежа в тийинах -->
    <input type="hidden" name="amount" value="{сумма чека в ТИИНАХ}"/>

    <!-- Поля Объекта Account -->
    <input type="hidden" name="account[{field_name}]" value="{field_value}"/>

    <!-- ==================== НЕОБЯЗАТЕЛЬНЫЕ ПОЛЯ ====================== -->
    <!-- Язык. Доступные значения: ru|uz|en
         Другие значения игнорируются
         Значение по умолчанию ru -->
    <input type="hidden" name="lang" value="ru"/>

    <!-- URL возврата после оплаты или отмены платежа.
         Если URL возврата не указан, он берется из заголовка запроса Referer.
         URL возврата может содержать параметры, которые заменяются Paycom при запросе.
         Доступные параметры для callback:
         :transaction - id транзакции или "null" если транзакцию не удалось создать
         :account.{field} - поля объекта Account
         Пример: https://your-service.uz/paycom/:transaction -->
    <input type="hidden" name="callback" value="{url возврата после платежа}"/>

    <!-- Таймаут после успешного платежа в миллисекундах.
         Значение по умолчанию 15
         После успешной оплаты, по истечении времени callback_timeout
         производится перенаправление пользователя по url возврата после платежа -->
    <input type="hidden" name="callback_timeout" value="{miliseconds}"/>

    <!-- Описание платежа
         Для описания платежа доступны 3 языка: узбекский, русский, английский.
         Для описания платежа на нескольких языках следует использовать
         несколько полей с атрибутом  name="description[{lang}]"
         lang может принимать значения ru|en|uz -->
    <input type="hidden" name="description" value="{Описание платежа}"/>

    <!-- Объект детализации платежа
         Поле для детального описания платежа, например, перечисления
         купленных товаров, стоимости доставки, скидки.
         Значение поля (value) — JSON-строка закодированная в BASE64 -->
    <input type="hidden" name="detail" value="{JSON объект детализации в BASE64}"/>
    <!-- ================================================================== -->

    <button type="submit">Оплатить с помощью <b>Payme</b></button>
</form>
