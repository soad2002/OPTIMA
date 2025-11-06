// قراءة الكلمة من الرابط
const params = new URLSearchParams(window.location.search);
const query = params.get("search");

// عرض الكلمة في العنوان
if (query) {
  document.getElementById("page-title").innerHTML = `نتائج البحث عن: ${query}`;
}

function searchProducts() {
  const query = document.getElementById("search").value;
  const list = document.getElementById("product-list");
  list.innerHTML = `<p>نتائج البحث عن: <b>${query}</b></p>`;
}

