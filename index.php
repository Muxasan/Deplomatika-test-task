<!DOCTYPE html>
<html lang='ru'>

<head>
    <meta charset='utf-8'>
    <script src="/js/form.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <style>
      .hidden {
        display:none;
      }
    </style>
</head>

<body>
  <form id="bitrix" method="POST">
    <label>
      Ваше имя:
      <input type="text" name="name" id="name" autofocus>
    </label>
    <label>
      Телефон:
      <input type="phone" name="phone" id="phone" required>
    </label>

    <label>
      Почта:
      <input type="email" name="email" id="email" required>
    </label>

    <label>
      Тип доставки:
      <select name="specialization">
        <option value="self-delivery" selected>Самовывоз</option>
        <option value="delivery">Доставка</option>
      </select>
    </label>

    <button type="submit" disabled>Отправить заявку</button>
    <div id="loader" class="hidden">Отправляем...</div>
  </form>
</body>
  <script>
      const applicantForm = $('#bitrix');
      $(applicantForm).on('change', 'input', checkValidity);
      $(applicantForm).on('submit', handleFormSubmit);
  </script>
</html>