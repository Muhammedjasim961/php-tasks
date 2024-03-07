function confirmDelete(){

    return confirm("Are You Sure You Want To Delete This Employee");
}

function formReset(){
    const form = document.getElementById('employee-form');
    form.reset();

    document.getElementById('firstName').value = '';
    document.getElementById('lastName').value = '';
    document.getElementById('email').value = '';
    document.getElementById('salary').value = '';
    document.getElementById('department').value = '';

}