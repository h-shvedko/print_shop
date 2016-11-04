<style>
.hidescreen {
     position: absolute;
	 z-index: 9998; 
	 width: 100%;
	 height: 900px;
	 background: #ffffff;
	 opacity: 0.7;
	 filter: alpha(opacity=70);
	 left:0;
	 top:0;
}
.modalOrder {
	padding: 15px;
	 z-index: 9999;
	 position: absolute;
	 left: 15%;
	 top: 40%;
	 background: #ffffff;
	 border: 1px solid #000000;
	 border-radius: 3px;
	 box-shadow: 0 0 15px rgba(0,0,0,0.5);
	 text-align: left;
}

.modalOrder > div {
	font-weight: bold;
}
</style>
<div class="row-fluid">
	<div class="span12">
	<h3>Заказы</h3>
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>№пп</th>
					<th>Номер заказа</th>
					<th>Клиент</th>
					<th>Телефон</th>
					<th>E-mail</th>
					<th>Сумма заказа</th>
					<th>Дата заказа</th>
					<th>Статус</th>
					<th>Действие</th>
				</tr>
			</thead>
			<tbody ng-controller="OrdersController as store">
				<tr ng-repeat="horder in store.horders">
					<td>{{horder.npp}}</td>
					<td>{{horder.num}}</td>
					<td>{{horder.user}}</td>
					<td>{{horder.phone}}</td>
					<td>{{horder.email}}</td>
					<td>{{horder.total_price}}</td>
					<td>{{horder.date_horder}}</td>
					<td>{{horder.status}}</td>
					<td>
						<a href  ng-click="horderId = !horderId">Просмотр</a>
						<div class="hidescreen" ng-show="horderId" ng-click="horderId = !horderId"></div>
						<div ng-show="horderId" class="modalOrder">
							<div style="margin-bottom: 5px;">Заказ № {{horder.num}}</div>
							<div style="margin-bottom: 5px;">Клиент: {{horder.user}}</div>
							<div style="margin-bottom: 5px;">Телефон: {{horder.phone}}</div>
							<div style="margin-bottom: 5px;">E-mail: {{horder.email}}</div>
							<div style="margin-bottom: 5px;">Статус: {{horder.status}}</div>
							<div style="margin-bottom: 5px;">Редактирование статуса: 
								<select ng-model="horder.status" style="margin-bottom: 5px;">
									<option ng-repeat="status in statuses track by status.id" value="{{status.id}}" ng-click="save(horder.id, status.id, status.name)">{{status.name}}</option>
								</select>
							</div>
							<hr>
							<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>№пп</th>
									<th>Скроки</th>
									<th>Название продукта</th>
									<th>Тираж</th>
									<th>Материал</th>
									<th>Покрытие</th>
									<th>Кол-во</th>
									<th>Цена</th>
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="order in horder.orders">
									<td>{{order.npp}}</td>
									<td>{{order.srok}}</td>
									<td>{{order.product}}</td>
									<td>{{order.tirazh}}</td>
									<td>{{order.material}}</td>
									<td>{{order.pokritie}}</td>
									<td>{{order.cnt}}</td>
									<td>{{order.amount}}</td>
						</div>
					
					</td>
				</tr>
			</tbody>

		</table>
		
		
	</div>
</div>