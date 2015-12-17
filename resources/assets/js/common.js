function hasNoEmptyInput() {
    $("input").filter(function () {
        return $.trim($(this).val()).length > 0;
    }).length == 0;
}