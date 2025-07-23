
function f() {
    let token = csrf.name;
    let value = csrf.value;

    console.log(token);
    console.log(value);

}



document.getElementById('myForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData();
    const imageInput = document.getElementById('imageInput');

    for (let i = 0; i < imageInput.files.length; i++) {
        formData.append('images[]', imageInput.files[i]);
    }

    fetch('upload.php', {
        method: 'POST',
        body: formData
    })
        .then(res => res.text())
        .then(data => {
            console.log(data);
        })
        .catch(err => console.error('Error:', err));
});

