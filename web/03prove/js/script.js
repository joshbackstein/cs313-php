function updateCartSize(num) {
  document.getElementById("cart-size").innerText = num;
}

function addProduct(code) {
  var id = "qty-" + code;
  var qtyString = document.getElementById(id).value;

  // Abort if quantity is empty or not a number
  if (qtyString.length <= 0 || isNaN(qtyString)) {
    return;
  }

  var qty = Number(qtyString);
  var data = {
    "action": "add",
    "code": code,
    "num": qty
  };
  var dataStr = JSON.stringify(data);

  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    // If request is finished and response is ready...
    if (this.readyState == 4) {
      if (this.status == 200) {
        // Request was successful, so update the cart size
        var cartSize = JSON.parse(this.responseText).size;
        updateCartSize(cartSize);
      }
    }
  };
  xhr.open("POST", "update-cart.php", true);
  xhr.send(dataStr);
}
