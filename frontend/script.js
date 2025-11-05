function searchProducts() {
  const query = document.getElementById("search").value;
  const list = document.getElementById("product-list");
  list.innerHTML = `<p>نتائج البحث عن: <b>${query}</b></p>`;
}

