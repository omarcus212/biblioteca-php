document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.item-checkbox');
    const updateButton = document.getElementById('updateButton');
    const deleteButton = document.getElementById('deleteButton');
    const actionForm = document.getElementById('actionForm');
    const selectedIdsInput = document.getElementById('selectedIds');
    const formMethodInput = document.getElementById('formMethod');
    const form = document.getElementById('form_home');
    const submitButton = document.getElementById('submitButton');
    const confirmeDelete = document.getElementById('confirme');
    const closeModalDelete = document.getElementById('closeModalDelete');
    const cancelDelete = document.getElementById('cancelBtn');


    const checkRequiredFields = () => {
        const requiredFields = form.querySelectorAll('input[required]');
        const allFilled = Array.from(requiredFields).every(input => input.value.trim() !== '');
        submitButton.disabled = !allFilled;
    }


    form.querySelectorAll('input[required]').forEach(input => {
        input.addEventListener('input', checkRequiredFields);
    });

    checkRequiredFields();

    const updateButtonStates = () => {
        const checkedItems = document.querySelectorAll('.item-checkbox:checked');

        if (checkedItems.length === 0) {
            updateButton.classList.add('hidden')
            deleteButton.classList.add('hidden')
            updateButton.disabled = true;
            deleteButton.disabled = true;
        } else if (checkedItems.length === 1) {
            updateButton.classList.remove('hidden')
            deleteButton.classList.remove('hidden')
            updateButton.disabled = false;
            deleteButton.disabled = false;
        } else {
            updateButton.classList.add('hidden')
            updateButton.disabled = true;
            deleteButton.disabled = false;
        }
    }


    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener('change', updateButtonStates);
    });

    // Função para coletar os IDs das checkboxes selecionadas
    const getSelectedIds = () => {
        const checkedItems = document.querySelectorAll('.item-checkbox:checked');
        return Array.from(checkedItems).map(checkbox => checkbox.value);
    }

    deleteButton.addEventListener('click', function (e) {
        e.preventDefault();
        modalDelete.classList.remove('hidden')

    });

    closeModalDelete.addEventListener('click', function (e) {
        e.preventDefault();
        modalDelete.classList.add('hidden');
    });

    cancelDelete.addEventListener('click', function (e) {
        e.preventDefault();
        modalDelete.classList.add('hidden');
    });


    window.addEventListener('click', function (event) {
        if (event.target === modalDelete) {
            modalDelete.classList.add('hidden');
        }
    });

    confirmeDelete.addEventListener("click", () => {

        const selectedIds = getSelectedIds();
        if (selectedIds.length > 0) {
            selectedIdsInput.value = JSON.stringify(selectedIds);
            formMethodInput.value = "DELETE";
            actionForm.action = '/library/publisher';
            actionForm.submit();
        }

    })

    updateButton.addEventListener('click', function (e) {
        e.preventDefault();

        const selectedIds = getSelectedIds();
        if (selectedIds.length === 1) {
            selectedIdsInput.value = JSON.stringify(selectedIds);
            formMethodInput.value = "POST";
            actionForm.action = '/library/publisher/getdata';
            actionForm.submit();
        }
    });

    document.getElementById('sendEmail').addEventListener('click', () => {
        document.getElementById('sendEmail').classList.add('hidden');
    })

    document.getElementById('searchForm').addEventListener('submit', function (event) {
        event.preventDefault();

        const form = event.target;
        const formData = new FormData(form);
        const params = new URLSearchParams(formData).toString();

        const url = `${form.action}?${params}`;

        fetch(url, {
            method: 'GET',
        }).then(response => response.ok)
            .then(data => {
                window.history.pushState({}, '', url);
                window.location.reload();
            })

    });


    const openModalBtn = document.getElementById('openModalBtn');
    const modal = document.getElementById('modal');
    const closeModalBtns = document.querySelectorAll('#closeModalBtn');

    openModalBtn.addEventListener('click', function () {
        modal.classList.remove('hidden');
    });

    closeModalBtns.forEach(button => {
        button.addEventListener('click', function () {
            modal.classList.add('hidden');
        });
    });

    window.addEventListener('click', function (event) {
        if (event.target === modal) {
            modal.classList.add('hidden');
        }
    });

});

