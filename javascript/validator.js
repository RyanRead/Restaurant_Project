//***************************************************************************************
// chefSignInForm
// This checks to make sure that the fields are not left empty and that the username
// is only letter characters and that the password is letters followed by at least
// one digit.
// Returns: True if all input with above criteria is met.
//			False the fields are empty or the username has non-letter characters, and/or
//                if the password field is not letters followed by at least one digit.
//***************************************************************************************

function chefSignInForm(event) {
    var elements = event.currentTarget;
    var a = elements[0].value;
    var b = elements[1].value;
    var result = true;
    var Uname_v = /^(\S*)?[a-zA-Z\d]+$/;
    var pswd_v = /^(\S*)?\d+(\S*)?$/;
    var myNode = document.getElementById("errorList");
    while (myNode.firstChild) {
        myNode.removeChild(myNode.firstChild);
    }

    document.getElementById("cName").classList.remove("errBorder");
    document.getElementById("pswd").classList.remove("errBorder");
    document.getElementById("errorBox").classList.add("hide");

    if (a == null || a == "" || !Uname_v.test(a)) {

        document.getElementById("cName").classList.add("errBorder");
        var node = document.createElement("li");
        var textNode = document.createTextNode("Username is empty or invalid.");
        node.appendChild(textNode);
        document.getElementById("errorList").appendChild(node);
        document.getElementById("errorBox").classList.remove("hide");
        result = false;
    }

    if (b == null || b == "" || !pswd_v.test(b)) {

        document.getElementById("pswd").classList.add("errBorder");
        var node = document.createElement("li");
        var textNode = document.createTextNode("Invalid password format (8 characters long at least one non-letter)");
        node.appendChild(textNode);
        document.getElementById("errorList").appendChild(node);
        document.getElementById("errorBox").classList.remove("hide");
        result = false;
    }


    if (result == false) {
        event.preventDefault();
    }
}



//***************************************************************************************
// serverSignInForm
// This just checks for if the code field is empty or isn't exactly 6 digits.
// Returns: True if all input with above criteria is met.
//			False the code field is empty or is not exactly 6 digits.
//***************************************************************************************
function serverSignInForm(event) {
    var elements = event.currentTarget;
    var a = elements[0].value;
    var result = true;
    var code_v = /^\d{6}$/;

    document.getElementById("code").classList.remove("errBorder");
    document.getElementById("errorBox").classList.add("hide");

    var myNode = document.getElementById("errorList");
    while (myNode.firstChild) {
        myNode.removeChild(myNode.firstChild);
    }

    if (a == null || a == "" || !code_v.test(a)) {

        document.getElementById("code").classList.add("errBorder");
        var node = document.createElement("li");
        var textNode = document.createTextNode("Code is invalid. (Ask manager for your 6 digit code)");
        node.appendChild(textNode);
        document.getElementById("errorList").appendChild(node);
        document.getElementById("errorBox").classList.remove("hide");
        result = false;
    }

    if (result == false) {
        event.preventDefault();
    }
}


//***************************************************************************************
// addMenuCheck
// This checks to make sure the name field is not left empty and a valid name is input.
// It also makes sure that the input to the instock and minstock fields are non-negative.
// Also makes sure unit field is not empty.
// Returns: True if all input with above criteria is met.
//			False if the name box is left empty or has improper input, if either the
//                instock or minstock fields negative, and/or the unit box is left empty.
//***************************************************************************************
function addIngredientsCheck(event) {
    var elements = event.currentTarget;
    var a = elements[0].value;
    var b = elements[1].value;
    var c = elements[2].value;
    var d = elements[3].value;

    var result = true;
    var nameCheck = /^([a-zA-Z]+ *[a-zA-Z]*)+$/;

    document.getElementById("name_of_ingredient").classList.remove("errBorder");
    document.getElementById("in_stock").classList.remove("errBorder");
    document.getElementById("min_stock").classList.remove("errBorder");
    document.getElementById("ingredient_unit").classList.remove("errBorder");
    document.getElementById("errorAddIngredientBox").classList.add("hide");

    var myNode = document.getElementById("errorNewIngredientList");
    while (myNode.firstChild) {
        myNode.removeChild(myNode.firstChild);
    }

    if (a == null || a == "" || !nameCheck.test(a)) {

        document.getElementById("name_of_ingredient").classList.add("errBorder");
        var node = document.createElement("li");
        var textNode = document.createTextNode("Name cannot be empty and can only be letters/spaces.");
        node.appendChild(textNode);
        document.getElementById("errorNewIngredientList").appendChild(node);
        document.getElementById("errorAddIngredientBox").classList.remove("hide");
        result = false;
    }

    if (b == null || b == "") {

        document.getElementById("in_stock").classList.add("errBorder");
        var node = document.createElement("li");
        var textNode = document.createTextNode("# In Stock cannot be empty.");
        node.appendChild(textNode);
        document.getElementById("errorNewIngredientList").appendChild(node);
        document.getElementById("errorAddIngredientBox").classList.remove("hide");
        result = false;
    } else if (b < 0) {
        document.getElementById("in_stock").classList.add("errBorder");
        var node = document.createElement("li");
        var textNode = document.createTextNode("# In Stock cannot be negative");
        node.appendChild(textNode);
        document.getElementById("errorNewIngredientList").appendChild(node);
        document.getElementById("errorAddIngredientBox").classList.remove("hide");
        result = false;
    }

    if (c == null || c == "") {

        document.getElementById("min_stock").classList.add("errBorder");
        var node = document.createElement("li");
        var textNode = document.createTextNode("Minimum Stock cannot be empty.");
        node.appendChild(textNode);
        document.getElementById("errorNewIngredientList").appendChild(node);
        document.getElementById("errorAddIngredientBox").classList.remove("hide");
        result = false;
    } else if (c < 0) {
        document.getElementById("min_stock").classList.add("errBorder");
        var node = document.createElement("li");
        var textNode = document.createTextNode("Minimum Stock cannot be negative");
        node.appendChild(textNode);
        document.getElementById("errorNewIngredientList").appendChild(node);
        document.getElementById("errorAddIngredientBox").classList.remove("hide");
        result = false;
    }

    if (d == null || d == "" || !nameCheck.test(d)) {

        document.getElementById("ingredient_unit").classList.add("errBorder");
        var node = document.createElement("li");
        var textNode = document.createTextNode("Unit cannot be empty and can only be letters/spaces.");
        node.appendChild(textNode);
        document.getElementById("errorNewIngredientList").appendChild(node);
        document.getElementById("errorAddIngredientBox").classList.remove("hide");
        result = false;
    }

    if (result == false) {
        event.preventDefault();
    }
}

//***************************************************************************************
// addMenuCheck
// This checks to make sure the name field is not left empty and a valid name is input.
// It also ensures at least one checkbox is checked and to make sure the value entered
// for the amount is non-negative.
// Returns: True if all input with above criteria is met.
//			False if the name box is left empty or with improper input, no checkboxes
//                are checked, and/or the amount input is negative.
//***************************************************************************************
function addMenuCheck(event) {
    var elements = event.currentTarget;
    var checkList = document.forms[0];
    var a = elements[0].value;

    var result = true;
    var nameCheck = /^([a-zA-Z]+ *[a-zA-Z]*)+$/;

    document.getElementById("item_name").classList.remove("errBorder");
    document.getElementById("errorNewMenuBox").classList.add("hide");

    var myNode = document.getElementById("errorNewMenuList");
    while (myNode.firstChild) {
        myNode.removeChild(myNode.firstChild);
    }

    if (a == null || a == "" || !nameCheck.test(a)) {

        document.getElementById("item_name").classList.add("errBorder");
        var node = document.createElement("li");
        var textNode = document.createTextNode("New Item cannot be empty and can only be letters/spaces.");
        node.appendChild(textNode);
        document.getElementById("errorNewMenuList").appendChild(node);
        document.getElementById("errorNewMenuBox").classList.remove("hide");
        result = false;
    }

    var isChecked = false;
    var arrayOfChecked = [];
    for (var i = 2; i < checkList.length - 2; i++) {
        if (!isChecked && (i % 2 == 0)) {
            if (checkList[i].checked) {
                isChecked = true;
                arrayOfChecked.push(i);
            }
        }
    }

    if (!isChecked) {
        var node = document.createElement("li");
        var textNode = document.createTextNode("Must check at least one ingredient.");
        node.appendChild(textNode);
        document.getElementById("errorNewMenuList").appendChild(node);
        document.getElementById("errorNewMenuBox").classList.remove("hide");
        result = false;
    }

    for (var i = 0; i < arrayOfChecked.length; i++) {
        var index = arrayOfChecked[i] + 1;
        if (elements[index].value == null || elements[index].value == "") {
            var node = document.createElement("li");
            var textNode = document.createTextNode("Must put value in for all checked ingredients.");
            node.appendChild(textNode);
            document.getElementById("errorNewMenuList").appendChild(node);
            document.getElementById("errorNewMenuBox").classList.remove("hide");
            result = false;

        } else if (elements[index].value < 0) {
            var node = document.createElement("li");
            var textNode = document.createTextNode("Value for ingredient cannot be negative.");
            node.appendChild(textNode);
            document.getElementById("errorNewMenuList").appendChild(node);
            document.getElementById("errorNewMenuBox").classList.remove("hide");
            result = false;

        }
    }


    if (result == false) {
        event.preventDefault();
    }
}


//***************************************************************************************
// addNewCategoryCheck
// This checks to make sure only letters are entered as well as it is not empty when
// the submit button is clicked.
// Returns: True if they have entered a valid category name.
//			False if they have entered nothing or non-letters.
//***************************************************************************************
function addNewCategoryCheck(event) {
    var elements = event.currentTarget;
    var a = elements[0].value;

    var result = true;
    var nameCheck = /^([a-zA-Z]+ *[a-zA-Z]*)+$/;

    document.getElementById("category_name").classList.remove("errBorder");
    document.getElementById("errorNewCategoryBox").classList.add("hide");

    var myNode = document.getElementById("errorNewCategoryList");
    while (myNode.firstChild) {
        myNode.removeChild(myNode.firstChild);
    }

    if (a == null || a == "" || !nameCheck.test(a)) {

        document.getElementById("category_name").classList.add("errBorder");
        var node = document.createElement("li");
        var textNode = document.createTextNode("Category cannot be empty and can only be letters/spaces.");
        node.appendChild(textNode);
        document.getElementById("errorNewCategoryList").appendChild(node);
        document.getElementById("errorNewCategoryBox").classList.remove("hide");
        result = false;
    }


    if (result == false) {
        event.preventDefault();
    }

}



//***************************************************************************************
// addMoreStockCheck
// This function checks to make sure the amount box is not empty when the submit button
// is clicked as well as denies users to put negative numbers.
// Returns: True if they have added to the order.
//			False if they havent added anything to the order. 
//***************************************************************************************
function addMoreStockCheck(event) {
    var elements = event.currentTarget;
    var a = elements[1].value;
    var numCheck = /^[0-9]+(\.[0-9]+)?$/;

    var result = true;

    document.getElementById("add_stock").classList.remove("errBorder");
    document.getElementById("errorAddStockBox").classList.add("hide");

    var myNode = document.getElementById("errorAddStockList");
    while (myNode.firstChild) {
        myNode.removeChild(myNode.firstChild);
    }

    if (a == null || a == "") {

        document.getElementById("add_stock").classList.add("errBorder");
        var node = document.createElement("li");
        var textNode = document.createTextNode("Amount cannot be empty.");
        node.appendChild(textNode);
        document.getElementById("errorAddStockList").appendChild(node);
        document.getElementById("errorAddStockBox").classList.remove("hide");
        result = false;
    } else if (a < 0) {
        document.getElementById("add_stock").classList.add("errBorder");
        var node = document.createElement("li");
        var textNode = document.createTextNode("Amount cannot be negative.");
        node.appendChild(textNode);
        document.getElementById("errorAddStockList").appendChild(node);
        document.getElementById("errorAddStockBox").classList.remove("hide");
        result = false;
    } else if (!numCheck.test(a))  {
        document.getElementById("add_stock").classList.add("errBorder");
        var node = document.createElement("li");
        var textNode = document.createTextNode("Amount must be a non-negative number.");
        node.appendChild(textNode);
        document.getElementById("errorAddStockList").appendChild(node);
        document.getElementById("errorAddStockBox").classList.remove("hide");
        result = false;
    }


    if (result == false) {
        event.preventDefault();
    }

}

//***************************************************************************************
// addItemsToOrderCheck
// This function makes sure there is at least one item checked off and adds an error
// box accordingly.
// Returns: True if they have added to the order.
//			False if they havent added anything to the order. 
//***************************************************************************************
function addItemsToOrderCheck(event) {
    var elements = event.currentTarget;
    var checkList = document.forms[0];

    var result = true;

    document.getElementById("errorNewOrderBox").classList.add("hide");

    var myNode = document.getElementById("errorMewOrderList");
    while (myNode.firstChild) {
        myNode.removeChild(myNode.firstChild);
    }

    var isChecked = false;
    for (var i = 0; i < checkList.length - 2; i++) {
        if (!isChecked) {
            if (checkList[i].checked) {
                isChecked = true;
                break;
            }
        }
    }

    if (!isChecked) {
        var node = document.createElement("li");
        var textNode = document.createTextNode("Must check at least one ingredient.");
        node.appendChild(textNode);
        document.getElementById("errorMewOrderList").appendChild(node);
        document.getElementById("errorNewOrderBox").classList.remove("hide");
        result = false;
    }


    if (result == false) {
        event.preventDefault();
    }
}
