
document.addEventListener('DOMContentLoaded', function () {


    const selectAllCheckbox = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.item-checkbox');
    const updateButton = document.getElementById('updateButton');
    const deleteButton = document.getElementById('deleteButton');
    const actionForm = document.getElementById('actionForm');
    const selectedIdsInput = document.getElementById('selectedIds');
    const formMethodInput = document.getElementById('formMethod');
    const form = document.getElementById('form_home');
    const submitButton = document.getElementById('submitButton');
    const selectPublisher = document.getElementById('selectPublisher');
    const confirmeDelete = document.getElementById('confirme');
    const closeModalDelete = document.getElementById('closeModalDelete');
    const cancelDelete = document.getElementById('cancelBtn');


    const checkRequiredFields = () => {
        const requiredFields = ["ISBN", "publisher", "price", "name"];
        let allFieldsFilled = true;

        for (let i = 0; i < requiredFields.length; i++) {
            const fieldName = requiredFields[i];
            const element = form.elements[fieldName];

            if (element) {

                if (!selectPublisher.value) {
                    allFieldsFilled = true;
                    submitButton.classList.remove('hidden')
                    break;
                }

                if (element.tagName === "INPUT" && element.value.trim() === "") {
                    allFieldsFilled = true;
                    submitButton.classList.remove('hidden')
                    break;
                }

                allFieldsFilled = false;
                submitButton.classList.remove('hidden')

            } else {
                submitButton.classList.remove('hidden')
                allFieldsFilled = false;
            }

        }

        submitButton.disabled = allFieldsFilled;
    }

    Array.from(form.elements).forEach((element) => {
        if (element.type !== "submit") {
            element.addEventListener('input', checkRequiredFields);
            element.addEventListener('change', checkRequiredFields);
        }
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


    document.getElementById('sendEmail').addEventListener('click', () => {
        document.getElementById('sendEmail').classList.add('hidden');
    })

    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener('change', updateButtonStates);
    });

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

    confirmeDelete.addEventListener("click", (e) => {
        e.preventDefault();
        const selectedIds = getSelectedIds();
        if (selectedIds.length > 0) {
            selectedIdsInput.value = JSON.stringify(selectedIds);
            formMethodInput.value = "DELETE";
            actionForm.action = '/library/bookstore';
            actionForm.submit();
        }

    })


    updateButton.addEventListener('click', function (e) {
        e.preventDefault();

        const selectedIds = getSelectedIds();
        if (selectedIds.length === 1) {
            selectedIdsInput.value = JSON.stringify(selectedIds);
            formMethodInput.value = "POST";
            actionForm.action = '/library/bookstore/getdata';
            actionForm.submit();
        }
    });


    const orderButton = document.getElementById('orderButton');
    const searchForm = document.getElementById('FormSearch');
    const searchInput = document.getElementById('searchInput');

    orderButton.addEventListener('click', (event) => {
        const orderInput = document.getElementById('order');
        event.preventDefault();

        orderInput.value = orderInput.value === 'asc' ? 'desc' : 'asc';
        searchForm.action = "/library/bookstore/search";
        searchForm.submit();
    });


    searchInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            searchForm.submit();
        }
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
