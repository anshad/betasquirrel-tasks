let currentPage = 1;
let itemsPerPage = 10;
let sortBy = "id";
let sortOrder = "DESC";

document.getElementById("search-type").addEventListener("change", function () {
  const searchType = this.value;
  const searchValue2 = document.getElementById("search-value2");
  if (searchType === "between") {
    searchValue2.style.display = "inline";
  } else {
    searchValue2.style.display = "none";
  }
});

function loadDepartments() {
  const searchField = document.getElementById("search-field").value;
  const searchType = document.getElementById("search-type").value;
  const searchValue = document.getElementById("search-value").value;
  const searchValue2 = document.getElementById("search-value2").value;

  const url = `api.php?page=${currentPage}&itemsPerPage=${itemsPerPage}&sort=${sortBy}&order=${sortOrder}&searchField=${searchField}&searchType=${searchType}&searchValue=${searchValue}&searchValue2=${
    searchType === "between" ? searchValue2 : ""
  }`;

  const xhr = new XMLHttpRequest();
  xhr.open("GET", url, true);
  xhr.setRequestHeader("Content-Type", "application/json");
  xhr.onload = function () {
    if (xhr.status === 200) {
      const response = JSON.parse(xhr.responseText);
      const tbody = document.getElementById("departments-table-body");
      tbody.innerHTML = "";
      if (response.success) {
        response.data.departments.forEach((department) => {
          const row = document.createElement("tr");
          const cellId = document.createElement("td");
          cellId.textContent = department.id;
          row.appendChild(cellId);

          const cellName = document.createElement("td");
          cellName.textContent = department.name;
          row.appendChild(cellName);

          const cellAction = document.createElement("td");
          cellAction.className = "text-end";
          const editButton = document.createElement("button");
          editButton.className = "btn btn-warning btn-sm mx-3";
          editButton.textContent = "Edit";
          editButton.onclick = function () {
            showModal(department);
          };
          cellAction.appendChild(editButton);

          const deleteButton = document.createElement("button");
          deleteButton.className = "btn btn-danger btn-sm";
          deleteButton.textContent = "Delete";
          deleteButton.onclick = function () {
            deleteDepartment(department.id);
          };
          cellAction.appendChild(deleteButton);
          row.appendChild(cellAction);
          tbody.appendChild(row);
        });

        const totalPages = data?.data?.total_count / data?.data?.items_per_page;
        renderPagination(totalPages);
      } else {
        showAlert(
          "danger",
          "An error occurred while fetching the departments."
        );
        const row = document.createElement("tr");
        const cell = document.createElement("td");
        cell.colSpan = 3;
        cell.textContent = "No records found!";
        row.appendChild(cell);
        tbody.appendChild(row);
      }
    }
  };
  xhr.send();
}

function sort(column) {
  if (sortBy === column) {
    sortOrder = sortOrder === "ASC" ? "DESC" : "ASC";
  } else {
    sortBy = column;
    sortOrder = "ASC";
  }
  loadDepartments();
  updateSortIcons();
}

function updateSortIcons() {
  const headers = document.querySelectorAll("th.sortable");
  headers.forEach((header) => {
    const span = header.querySelector(".sort-icon");
    span.className = "sort-icon";
    if (header.getAttribute("data-column") === sortBy) {
      span.classList.add(sortOrder === "ASC" ? "asc" : "desc");
    }
  });
}

function prevPage() {
  if (currentPage > 1) {
    currentPage--;
    loadDepartments();
  }
}

function nextPage() {
  currentPage++;
  loadDepartments();
}

document
  .getElementById("department-form")
  .addEventListener("submit", saveDepartment);

function showAlert(type, message) {
  const alertContainer = document.getElementById("alert-container");
  const alert = document.createElement("div");
  alert.className = `alert alert-${type} alert-dismissible fade show`;
  alert.role = "alert";
  alert.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            </button>
        `;
  alertContainer.appendChild(alert);
}

function showModal(department = null) {
  const modalLabel = document.getElementById("departmentModalLabel");
  const departmentId = document.getElementById("department-id");
  const departmentName = document.getElementById("department-name");

  if (department) {
    modalLabel.textContent = "Edit Department";
    departmentId.value = department.id;
    departmentName.value = department.name;
  } else {
    modalLabel.textContent = "Add Department";
    departmentId.value = "";
    departmentName.value = "";
  }

  const departmentModal = new bootstrap.Modal(
    document.getElementById("departmentModal")
  );
  departmentModal.show();
}

function saveDepartment(event) {
  event.preventDefault();
  const id = document.getElementById("department-id").value;
  const name = document.getElementById("department-name").value;

  const xhr = new XMLHttpRequest();
  const url = "api.php" + (id ? "?id=" + id : "");
  const method = id ? "PUT" : "POST";
  xhr.open(method, url, true);
  xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        const res = JSON.parse(xhr.responseText);
        if (res.success) {
          showAlert("success", res.message);
          bootstrap.Modal.getInstance(
            document.getElementById("departmentModal")
          ).hide();
          loadDepartments();
        } else {
          showAlert("danger", res.message);
        }
      } else {
        showAlert("danger", "An error occurred while adding the department.");
        console.error(xhr.responseText);
      }
    }
  };
  xhr.send(JSON.stringify({ id, name }));
}

function search() {
  currentPage = 1;
  fetchDepartments();
}

function deleteDepartment(id) {
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!",
  }).then((result) => {
    if (result.isConfirmed) {
      const xhr = createRequest(
        // TODO: fix
        "DELETE",
        `api/department/${id}`,
        function (xhr) {
          if (xhr.status === 200) {
            const res = JSON.parse(xhr.responseText);
            if (res.success) {
              showAlert("success", res.message);
              loadDepartments();
            } else {
              showAlert("danger", res.message);
            }
          } else {
            showAlert(
              "danger",
              "An error occurred while deleting the department."
            );
            console.error(xhr.responseText);
          }
        }
      );

      xhr.send();
    }
  });
}

function renderPagination(totalPages) {
  const pagination = document.getElementById("pagination");
  pagination.innerHTML = "";

  if (currentPage > 1) {
    const prevPageItem = document.createElement("li");
    prevPageItem.className = "page-item";
    prevPageItem.innerHTML =
      '<button class="page-link" onclick="prevPage()" aria-label="Previous"><span aria-hidden="true">&laquo;</span></button>';
    pagination.appendChild(prevPageItem);
  }

  for (let i = 1; i <= totalPages; i++) {
    const pageItem = document.createElement("li");
    pageItem.className = `page-item ${i === currentPage ? "active" : ""}`;
    pageItem.innerHTML = `<button class="page-link" onclick="goToPage(${i})">${i}</button>`;
    pagination.appendChild(pageItem);
  }

  if (currentPage < totalPages) {
    const nextPageItem = document.createElement("li");
    nextPageItem.className = "page-item";
    nextPageItem.innerHTML =
      '<button class="page-link" onclick="nextPage()" aria-label="Next"><span aria-hidden="true">&raquo;</span></button>';
    pagination.appendChild(nextPageItem);
  }
}

function goToPage(page) {
  currentPage = page;
  loadDepartments();
}

window.onload = function () {
  loadDepartments();
};

/**
 * URL
 * Method
 * Data: query params, header, body
 * Call Ajax
 * Handle response
 */
