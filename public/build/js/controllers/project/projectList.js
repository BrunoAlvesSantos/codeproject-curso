angular.module('app.controllers')
	.controller('ProjectListController', [
		'$scope', '$routeParams', 'Project', function($scope, $routeParams, Project){
			$scope.projects = Project.query();

			//bom para verificar o que está vindo no scope
			//console.log($scope.projectNotes);
		}]);