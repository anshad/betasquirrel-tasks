function confirmDelete() {
  return confirm("Are you sure you want to delete this record?");
}

function resetForm(formId) {
  const form = document.getElementById(formId);
  form.reset();
}

function toggleBetweenInput() {
  const searchType = document.getElementById("searchType").value;
  const betweenInput = document.getElementById("betweenValue");
  betweenInput.style.display = searchType === "between" ? "block" : "none";
}
