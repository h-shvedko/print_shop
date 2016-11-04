$(document).ready(function() {

	/*$("a.fancy").fancybox({
		'transitionIn'	:	'elastic',
		'transitionOut'	:	'elastic',
		'speedIn'		:	600, 
		'speedOut'		:	200, 
		'overlayShow'	:	true
	});*/
	
	
	
});
(function() {

  var app = angular.module('gemStore', []);
	
	app.controller('basketController', [ '$scope', '$http', function basketController($scope, $http){
			
				$scope.basketAdd = function(s){
				   $http.post("/page/default/AjaxAddBasket/id/"+s)
						.success(function(response) {
									location = '/store/order';
								})
						.error(function(response) {
									alert('Ошибка добавления товара в корзину');
								});
				}
				
				
			}]);
			
	app.controller('StoreController', ['$scope', '$http', function($scope,$http){
    
	var store = this;
    store.orders = [];
		
		
		$scope.basketDelete = function(s){
				   $http.post("/store/order/AjaxDeleteOrder/id/"+s)
						.success(function(response) {
									store.orders = response;
									location = '/store/order';
								})
						.error(function(response) {
									alert('Ошибка удаления товара');
								});
				}
	
	}]);
	
	app.controller('OrdersController', ['$scope', '$http', function($scope,$http){
    
	var store = this;
	$scope.horderId = false;
	$scope.statuses = [];
    store.horders = [];
		
		$http.get("/admin/store/default/AjaxGetHorder")
				.success(function(response) {
							store.horders = response;
						})
				.error(function(response) {
							alert('Ошибка загрузки заказа');
						});
						
		$http.get("/admin/store/default/AjaxGetStatuses")
				.success(function(response) {
							$scope.statuses = response;
						})
				.error(function(response) {
							alert('Ошибка загрузки заказа');
						});
	$scope.save	= function(id, status, name){
		$http.post("/admin/store/default/changeStatus", {id: id, status: status})
					.success(function(response) {
						angular.forEach(store.horders, function(value, key){
							if(value.id === id)
							{
								store.horders[key].status = name;
							}
						});
						alert('Статус изменен.');
							})
					.error(function(response) {
								alert('Ошибка сохранения статуса');
							});
		
	}
	
	store.orders = [];
		
		$scope.orderShow = function(s){
			$scope.horderId = !$scope.horderId;
			$http.post("/admin/store/default/AjaxGetOrder/id/"+s)
					.success(function(response) {
								store.orders = response;
							})
					.error(function(response) {
								alert('Ошибка загрузки заказа');
							});
			}
	
	}]);
})();