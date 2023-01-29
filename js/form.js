async function handleFormSubmit(event) {
    event.preventDefault()
    const data = serializeForm(event.target)
  
    toggleLoader()
    await sendData(data)
    toggleLoader()
}

function serializeForm(form) {
    return $(form).serializeArray();
}

function toggleLoader() {
    const loader = document.getElementById('loader')
    loader.classList.toggle('hidden')
}

function checkValidity(event) {
    const formNode = event.target.form
    const isValid = formNode.checkValidity()
  
    formNode.querySelector('button').disabled = !isValid
}

async function sendData(data) {
    await $.ajax({
        url: '/app/handler.php',
        type: 'POST',
        data: data
    }).done(function (data) {
        alert('Ваша заявка отправлена!')
        console.log(data)
    }).fail(function (e) {
        alert(e.message)
    });
}