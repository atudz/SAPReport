/**
 * Application module list
 */

(function(){
	'use strict';
		
	angular.module('app', ['ngRoute'], function($interpolateProvider) {
	    $interpolateProvider.startSymbol('[[');
	    $interpolateProvider.endSymbol(']]');
	});
})();
