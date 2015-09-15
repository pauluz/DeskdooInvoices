var InvoiceApp = angular.module('InvoiceApp', []);

InvoiceApp.controller('ProductsListCtrl', ProductsListController);

function ProductsListController($scope) {
    $scope.phones = [
        {'name': 'Nexus S', 'snippet': 'Fast just got faster with Nexus S.'},
        {'name': 'Motorola XOOM with Wi-Fi', 'snippet': 'The Next, Next Generation tablet.'},
        {'name': 'MOTOROLA XOOM', 'snippet': 'The Next, Next Generation tablet.'}
    ];
    $scope.products;
}

ProductsListController.prototype.liczenie = function() {
    $scope.products++;
};

