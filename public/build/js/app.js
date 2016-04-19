var app = angular.module('app',[
    'ngRoute','angular-oauth2','app.controllers','app.services','app.filters','app.directives',
    'ui.bootstrap.typeahead','ui.bootstrap.datepicker','ui.bootstrap.tpls', 'ui.bootstrap.modal',
    'ngFileUpload', 'http-auth-interceptor'
]);

angular.module('app.controllers',['ngMessages','angular-oauth2']);
angular.module('app.services',['ngResource']);
angular.module('app.filters',[]);
angular.module('app.directives',[]);

app.provider('appConfig', ['$httpParamSerializerProvider', function($httpParamSerializerProvider) {
    var config = {
        baseUrl: 'http://codeproject:8000',
        project: {
            status: [
                { value: 1, label: 'Não iniciado'},
                { value: 2, label: 'Iniciado'},
                { value: 3, label: 'Concluído'}
            ]
        },
        projectTask:{
            status: [
                {value: 1, label: 'Incompleta'},
                {value: 2, label: 'Completa'}
            ]
        },
        urls: {
            projectFile: '/project/{{id}}/file/{{idFile}}'
        },
        utils: {
            transformRequest: function(data) {
                if(angular.isObject(data)) {
                    return $httpParamSerializerProvider.$get()(data);
                }
                return data;
            },
            transformResponse: function (data, headers) {
                var headersGetter = headers();
                if(headersGetter['content-type'] == 'application/json' || headersGetter['content-type'] == 'text/json') {
                    var dataJson = JSON.parse(data);
                    if (dataJson.hasOwnProperty('data')) {
                        dataJson = dataJson.data;
                    }
                    return dataJson;
                }
                return data;
            }
        }
    };

    return {
        config: config,
        $get: function() {
            return config;
        }
    }
}]);

app.config([
    '$routeProvider','$httpProvider', 'OAuthProvider', 'OAuthTokenProvider', 'appConfigProvider',
    function($routeProvider, $httpProvider, OAuthProvider, OAuthTokenProvider, appConfigProvider) {

        $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
        $httpProvider.defaults.headers.put['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';

        $httpProvider.defaults.transformRequest = appConfigProvider.config.utils.transformRequest;
        $httpProvider.defaults.transformResponse = appConfigProvider.config.utils.transformResponse;

        $httpProvider.interceptors.splice(0,1);
        $httpProvider.interceptors.splice(0,1);
        $httpProvider.interceptors.push('oauthFixInterceptor');

    $routeProvider
        .when('/login',{
            templateUrl: 'build/views/login.html',
            controller: 'LoginController'
        })
        .when('/logout',{
            resolve: {
                logout: ['$rootScope','$location', 'OAuthToken',function($rootScope,$location,OAuthToken){
                    OAuthToken.removeToken();
                    $rootScope.logado = false;

                    return $location.path('login');
                }]
            }
        })
        .when('/home', {
            templateUrl: 'build/views/home.html',
            controller: 'HomeController'
        })

        // Clients
        .when('/clients', {
            templateUrl: 'build/views/client/list.html',
            controller: 'ClientListController'
        })
        .when('/clients/new', {
            templateUrl: 'build/views/client/new.html',
            controller: 'ClientNewController'
        })
        .when('/clients/:id/edit', {
            templateUrl: 'build/views/client/edit.html',
            controller: 'ClientEditController'
        })
        .when('/clients/:id/remove', {
            templateUrl: 'build/views/client/remove.html',
            controller: 'ClientRemoveController'
        })

        // Projects
        .when('/projects',{
            templateUrl: 'build/views/project/list.html',
            controller: 'ProjectListController'
        })
        .when('/project/new',{
            templateUrl: 'build/views/project/new.html',
            controller: 'ProjectNewController'
        })
        .when('/project/:id/edit',{
            templateUrl: 'build/views/project/edit.html',
            controller: 'ProjectEditController'
        })
        .when('/project/:id/remove',{
            templateUrl: 'build/views/project/remove.html',
            controller: 'ProjectRemoveController'
        })

        // Project notes
        .when('/project/:id/notes',{
            templateUrl: 'build/views/project-note/list.html',
            controller: 'ProjectNoteListController'
        })
        .when('/project/:id/notes/:idNote/show',{
            templateUrl: 'build/views/project-note/show.html',
            controller: 'ProjectNoteShowController'
        })
        .when('/project/:id/notes/new',{
            templateUrl: 'build/views/project-note/new.html',
            controller: 'ProjectNoteNewController'
        })
        .when('/project/:id/notes/:idNote/edit',{
            templateUrl: 'build/views/project-note/edit.html',
            controller: 'ProjectNoteEditController'
        })
        .when('/project/:id/notes/:idNote/remove',{
            templateUrl: 'build/views/project-note/remove.html',
            controller: 'ProjectNoteRemoveController'
        })

        // Project files
        .when('/project/:id/files',{
            templateUrl: 'build/views/project-file/list.html',
            controller: 'ProjectFileListController'
        })
        .when('/project/:id/files/:idFile/show',{
            templateUrl: 'build/views/project-file/show.html',
            controller: 'ProjectFileShowController'
        })
        .when('/project/:id/files/new',{
            templateUrl: 'build/views/project-file/new.html',
            controller: 'ProjectFileNewController'
        })
        .when('/project/:id/files/:idFile/edit',{
            templateUrl: 'build/views/project-file/edit.html',
            controller: 'ProjectFileEditController'
        })
        .when('/project/:id/files/:idFile/remove',{
            templateUrl: 'build/views/project-file/remove.html',
            controller: 'ProjectFileRemoveController'
        })

        // Project tasks
        .when('/project/:id/tasks',{
            templateUrl: 'build/views/project-task/list.html',
            controller: 'ProjectTaskListController'
        })
        .when('/project/:id/task/:idTask/show',{
            templateUrl: 'build/views/project-task/show.html',
            controller: 'ProjectTaskShowController'
        })
        .when('/project/:id/task/new',{
            templateUrl: 'build/views/project-task/new.html',
            controller: 'ProjectTaskNewController'
        })
        .when('/project/:id/task/:idTask/edit',{
            templateUrl: 'build/views/project-task/edit.html',
            controller: 'ProjectTaskEditController'
        })
        .when('/project/:id/task/:idTask/remove',{
            templateUrl: 'build/views/project-task/remove.html',
            controller: 'ProjectTaskRemoveController'
        })

        // Project members
        .when('/project/:id/members',{
            templateUrl: 'build/views/project-member/list.html',
            controller: 'ProjectMemberListController'
        })
        .when('/project/:id/member/:idProjectMember/remove',{
            templateUrl: 'build/views/project-member/remove.html',
            controller: 'ProjectMemberRemoveController'
        })

        OAuthProvider.configure({
            baseUrl: appConfigProvider.config.baseUrl,
            clientId: 'appid1',
            clientSecret: 'secret', // optional
            grantPath: 'oauth/access_token'
        });

        /* Precisa remover quando subir para produção */
        OAuthTokenProvider.configure({
            name: 'token',
            options: {
                secure: false
            }
        });
}]);


app.run(['$rootScope', '$location', '$http', '$cookies', '$modal', 'httpBuffer', 'OAuth',
    function($rootScope, $location, $http, $cookies, $modal, httpBuffer, OAuth) {
        //AUTORIZAÇÃO
        $rootScope.$on('$routeChangeStart',function(event,next,current){
            if(next.$$route.originalPath != '/login'){
                if (!OAuth.isAuthenticated()){
                    $location.path('login');
                }
            }
        });

        $rootScope.$on('oauth:error', function(event, data) {
            // Ignore `invalid_grant` error - should be catched on `LoginController`.
            if ('invalid_grant' === data.rejection.data.error) {
                return;
            }

            // Refresh token when a `invalid_token` error occurs.
            if ('access_denied' === data.rejection.data.error) {

                httpBuffer.append(data.rejection.config, data.deferred);

                if (!$rootScope.loginModalOpened){
                    var modalInstance = $modal.open({
                        templateUrl: 'build/views/templates/loginModal.html',
                        controller: 'LoginModalController'

                    });
                    $rootScope.loginModalOpened = true;
                }
                return;
                if (!$rootScope.isRefreshingToken) {
                    $rootScope.isRefreshingToken = true;
                    return OAuth.getRefreshToken().then(function(response) {
                        $rootScope.isRefreshingToken = false;
                        return $http(data.rejection.config).then(function(response){
                            return data.deferred.resolve(response);
                        });
                    });
                } else {
                    return $http(data.rejection.config).then(function(response){
                        return data.deferred.resolve(response);
                    });
                }
            }

            // Redirect to `/login` with the `error_reason`.
            return $location.path('login');
        });
    }]);