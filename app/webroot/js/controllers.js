as.controller('GuestListCtrl', function($scope, $rootScope, $http, $location) {
        var load = function() {
            console.log('call load()...');
            $http.get($rootScope.appUrl + '/guests.json')
                    .success(function(data, status, headers, config) {
                        $scope.guests = data.guests;
                        angular.copy($scope.guests, $scope.copy);
                    });
        }

        load();

       /* $scope.addGuest = function() {
            console.log('call addPost');
            $location.path("/new-Guest");
        }

        $scope.editPost = function(index) {
            console.log('call editPost');
            $location.path('/edit-post/' + $scope.posts[index].Post.id);
        }

        $scope.delPost = function(index) {
            console.log('call delPost');
            var todel = $scope.posts[index];
            $http
                    .delete($rootScope.appUrl + '/posts/' + todel.Post.id + '.json')
                    .success(function(data, status, headers, config) {
                        load();
                    }).error(function(data, status, headers, config) {
            });
        }*/

});