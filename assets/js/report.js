function openPopupSales(obj) {
    var data = $(obj).serialize();

    var url = BASE_URL+'report/sales_pdf?'+data;

    window.open(url, 'report', "width=700,height=500");

    return false;
}

function openPopupInventory(obj) {
    var data = $(obj).serialize();

    var url = BASE_URL+'report/inventory_pdf?'+data;

    window.open(url, 'report', "width=700,height=500");

    return false;
}

function openPopupPurchases(obj) {
    var data = $(obj).serialize();

    var url = BASE_URL+'report/purchases_pdf?'+data;

    window.open(url, 'report', "width=700,height=500");

    return false;
}