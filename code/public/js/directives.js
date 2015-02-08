/* Loading directive */
reportesDespacho.directive('loading', function () {
    return {
        restrict: 'E',
        replace: true,
        template: '<div class="loading" style="margin-top: 15px;"><img src="images/loaders/loader5.gif"/></div>',
        link: function (scope, element, attr) {
            scope.$watch('loading', function () {
                $(element).show();
            });
        }
    }
});

/* ListFolders directive */
reportesDespacho.directive('showFolders', ['rootFactory', function (rootFactory) {
    return {
        scope: {
            ngModel: '='
        },
        link: function (scope, element, attr) {
            scope.root = rootFactory.raiz;
        },
        template: '<a href="{{ root }}/dashboard/folder/{{ ngModel.root }} "><i class="fa fa-folder-open fa-fw"></i> {{ ngModel.name }}</a>'
    }
}]);

/* Datapicker directive */
reportesDespacho.directive("datepicker", function () {
    return {
        restrict: "A",
        require: "ngModel",
        link: function (scope, elem, attrs, ngModelCtrl) {
            var updateModel = function (dateText) {
                scope.$apply(function () {
                    ngModelCtrl.$setViewValue(dateText);
                });
            };
            var options = {
                dateFormat: "dd/mm/yy",
                onSelect: function (dateText) {
                    updateModel(dateText);
                }
            };
            elem.datepicker(options);
        }
    }
});

/* Chergroup Directive */
reportesDespacho.directive('checkboxGroup', function () {
    return {
        restrict: 'E',
        controller: function ($scope, $attrs) {
            var self = this;
            var ngModels = [];
            var minRequired;
            self.validate = function () {
                var checkedCount = 0;
                angular.forEach(ngModels, function (ngModel) {
                    if (ngModel.$modelValue) {
                        checkedCount++;
                    }
                });
                console.log('minRequired', minRequired);
                console.log('checkedCount', checkedCount);
                var minRequiredValidity = checkedCount >= minRequired;
                angular.forEach(ngModels, function (ngModel) {
                    ngModel.$setValidity('checkboxGroup-minRequired', minRequiredValidity, self);
                });
            };

            self.register = function (ngModel) {
                ngModels.push(ngModel);
            };

            self.deregister = function (ngModel) {
                var index = this.ngModels.indexOf(ngModel);
                if (index != -1) {
                    this.ngModels.splice(index, 1);
                }
            };

            $scope.$watch($attrs.minRequired, function (value) {
                minRequired = parseInt(value, 10);
                self.validate();
            });
        }
    };
});

/* Inputs Directives */
reportesDespacho.directive('input', function () {
    return {
        restrict: 'E',
        require: ['?^checkboxGroup', '?ngModel'],
        link: function (scope, element, attrs, controllers) {
            var checkboxGroup = controllers[0];
            var ngModel = controllers[1];
            if (attrs.type == 'checkbox' && checkboxGroup && ngModel) {
                checkboxGroup.register(ngModel);
                scope.$watch(function () {
                    return ngModel.$modelValue;
                }, checkboxGroup.validate);
                scope.$on('$destroy', function () {
                    checkboxGroup.deregister(ngModel);
                });
            }
        }
    };
});
