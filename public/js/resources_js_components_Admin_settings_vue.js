"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_Admin_settings_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Admin/settings.vue?vue&type=script&setup=true&lang=js":
/*!*******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Admin/settings.vue?vue&type=script&setup=true&lang=js ***!
  \*******************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_1__);


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'settings',
  setup: function setup(__props, _ref) {
    var expose = _ref.expose;
    expose();
    var fileToSend = (0,vue__WEBPACK_IMPORTED_MODULE_0__.ref)(null);
    var baseExcel = (0,vue__WEBPACK_IMPORTED_MODULE_0__.ref)("");
    var avantExcel = (0,vue__WEBPACK_IMPORTED_MODULE_0__.ref)("");
    var avantSize = (0,vue__WEBPACK_IMPORTED_MODULE_0__.ref)(0);
    var baseSize = (0,vue__WEBPACK_IMPORTED_MODULE_0__.ref)(0);
    var btnControl = (0,vue__WEBPACK_IMPORTED_MODULE_0__.ref)(false);
    (0,vue__WEBPACK_IMPORTED_MODULE_0__.onMounted)(function () {
      btnControl.value = false;
    });

    function handleBase(event) {
      console.log(event);

      if (event.target.files.length === 0) {
        baseExcel.value = "";
        return;
      }

      baseSize.value = event.target.files[0].size;
      baseExcel.value = event.target.files[0];
      check();
    }

    function handleAvant(event) {
      console.log(event);

      if (event.target.files.length === 0) {
        avantExcel.value = "";
        return;
      }

      avantExcel.value = event.target.files[0];
      avantSize.value = event.target.files[0].size;
      check();
    }

    function check() {
      if (avantExcel.value == "" || baseExcel.value == "") {
        btnControl.value = true;
      } else if (avantExcel.value != "" && baseExcel.value != "") {
        btnControl.value = false;
      }
    }

    function handleSubmit() {
      if (baseSize.value < avantSize.value) {
        alert("la taille de la base plate est normalement superieur a la base de l'avancemnt");
      } else {
        var data = new FormData();
        data.append('base', baseExcel.value);
        data.append('avant', avantExcel.value);
        axios__WEBPACK_IMPORTED_MODULE_1___default().post('/api/storeExcel', data).then(function (response) {
          console.log(response.data);
        });
      }
    }

    var __returned__ = {
      fileToSend: fileToSend,
      baseExcel: baseExcel,
      avantExcel: avantExcel,
      avantSize: avantSize,
      baseSize: baseSize,
      btnControl: btnControl,
      handleBase: handleBase,
      handleAvant: handleAvant,
      check: check,
      handleSubmit: handleSubmit,
      ref: vue__WEBPACK_IMPORTED_MODULE_0__.ref,
      watch: vue__WEBPACK_IMPORTED_MODULE_0__.watch,
      onMounted: vue__WEBPACK_IMPORTED_MODULE_0__.onMounted,
      axios: (axios__WEBPACK_IMPORTED_MODULE_1___default())
    };
    Object.defineProperty(__returned__, '__isScriptSetup', {
      enumerable: false,
      value: true
    });
    return __returned__;
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Admin/settings.vue?vue&type=template&id=0190a48e":
/*!************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Admin/settings.vue?vue&type=template&id=0190a48e ***!
  \************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = ["onSubmit"];
var _hoisted_2 = ["disabled"];
function render(_ctx, _cache, $props, $setup, $data, $options) {
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("form", {
    "class": "bg-white pt-5 grid grid-cols-1 gap-2 place-items-center border border-black",
    onSubmit: (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)($setup.handleSubmit, ["prevent"])
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
    "for": "base",
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["bg-blue-600 px-3 py-1 cursor-pointer rounded-md shadow-sm hover:opacity-80 w-[200px]", $setup.baseExcel != '' ? 'bg-green-600' : ''])
  }, "Importer la base plate ", 2
  /* CLASS */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    "class": "hidden",
    name: "base",
    id: "base",
    type: "file",
    accept: ".xls,.xlsx,application/vnd.ms-excel,\r\n    application/vnd.openxmlformats-officedocument.spreadsheetml.sheet\r\n                     ",
    onChange: $setup.handleBase,
    required: ""
  }, null, 32
  /* HYDRATE_EVENTS */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
    "for": "avant",
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["bg-blue-600 px-3 py-1 cursor-pointer rounded-md shadow-sm hover:opacity-80 w-[200px]", $setup.avantExcel != '' ? 'bg-green-600' : ''])
  }, "Importer l'avancement", 2
  /* CLASS */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    "class": "hidden",
    name: "avant",
    type: "file",
    accept: ".xls,.xlsx,application/vnd.ms-excel,\r\n    application/vnd.openxmlformats-officedocument.spreadsheetml.sheet\r\n                     ",
    onChange: $setup.handleAvant,
    id: "avant",
    required: ""
  }, null, 32
  /* HYDRATE_EVENTS */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <label  for=\"inputFileUpload\">Choose file</label> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    disabled: $setup.btnControl,
    type: "submit",
    "class": "border shadow-sm border-black rounded-sm bg-green-400 p-1 hover:opacity-80"
  }, " Upload", 8
  /* PROPS */
  , _hoisted_2)], 40
  /* PROPS, HYDRATE_EVENTS */
  , _hoisted_1)]);
}

/***/ }),

/***/ "./resources/js/components/Admin/settings.vue":
/*!****************************************************!*\
  !*** ./resources/js/components/Admin/settings.vue ***!
  \****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _settings_vue_vue_type_template_id_0190a48e__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./settings.vue?vue&type=template&id=0190a48e */ "./resources/js/components/Admin/settings.vue?vue&type=template&id=0190a48e");
/* harmony import */ var _settings_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./settings.vue?vue&type=script&setup=true&lang=js */ "./resources/js/components/Admin/settings.vue?vue&type=script&setup=true&lang=js");
/* harmony import */ var C_Users_hulk_Desktop_Absys_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,C_Users_hulk_Desktop_Absys_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_settings_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_settings_vue_vue_type_template_id_0190a48e__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/components/Admin/settings.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/components/Admin/settings.vue?vue&type=script&setup=true&lang=js":
/*!***************************************************************************************!*\
  !*** ./resources/js/components/Admin/settings.vue?vue&type=script&setup=true&lang=js ***!
  \***************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_settings_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_settings_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./settings.vue?vue&type=script&setup=true&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Admin/settings.vue?vue&type=script&setup=true&lang=js");
 

/***/ }),

/***/ "./resources/js/components/Admin/settings.vue?vue&type=template&id=0190a48e":
/*!**********************************************************************************!*\
  !*** ./resources/js/components/Admin/settings.vue?vue&type=template&id=0190a48e ***!
  \**********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_settings_vue_vue_type_template_id_0190a48e__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_settings_vue_vue_type_template_id_0190a48e__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./settings.vue?vue&type=template&id=0190a48e */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Admin/settings.vue?vue&type=template&id=0190a48e");


/***/ })

}]);