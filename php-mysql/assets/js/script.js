function confirmDelete() {
  return confirm("Are you sure you want to delete this employee?");
}

function resetForm() {
  const form = document.getElementById("employee-form");
  form.reset();

  document.getElementById("first-name").value = "";
  document.getElementById("last-name").value = "";
  document.getElementById("email").value = "";
  document.getElementById("salary").value = "";
  document.getElementById("department").value = "";
}
