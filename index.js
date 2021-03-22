"use strict";

var Teste = {

  index: {

    init: function (config) {
      this.bindEvents();
    },

    bindEvents: function () {
      $('#btn-pesquisar').click(function () {
        $('#tabelaTeste').bootstrapTable('refresh');
      });

      $('#btn-limpar').click(function () {
        $('#busca').val('');
        $('#tabelaTeste').bootstrapTable('refresh');
      });
    },

    initDataTable: function () {
      window.document.listEvents = {
        'excluirTeste': function (testeId) {

          swal.fire({
            title: 'Deseja excluir o Teste selecionado?',
            text: 'Esta ação não poderá ser revertida.',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim',
            cancelButtonText: 'Não'
          }).then((result) => {
            if (result.value) {
              $.ajax({
                method: "DELETE",
                url: $('#hdn-url-excluir').val(),
                data:{
                       testeId : testeId
                },
                beforeSend: function () {
                  $(".ajax-loading").show();
                },
                success: function (retorno) {
                  toastr.success(retorno.message, "Sucesso");
                  $(".ajax-loading").hide();
                  $('#tabelaTeste').bootstrapTable('refresh');
                },
                error: function (retorno) {
                  toastr.error(retorno.message, "Erro");
                  $(".ajax-loading").hide();
                },
              });
            }
          });
        },


        'acaoFormatter': function (item, row) {

          let urlEdit = $('#hdn-url-edit').val();
          urlEdit = urlEdit.replace("id", row.id);
          let editButton = [
            '<a href="' + urlEdit + '" class="btn btn-success btn-icon kt-margin-l-5" title="Editar Teste">',
            '<i class="fa fa-edit"></i>',
            '</a>'
          ].join('');

          let deleteButton = [];

          // Só exibe para o perfil Super Admin
          if ($('#hdn-url-excluir').val() !== '') {

            deleteButton = [
              '<button type="button" onclick="window.document.listEvents.excluirTeste(' + row.id + ')" ',
              'class="btn btn-danger btn-icon kt-margin-l-5" title="Excluir Teste">',
              '<i class="fa fa-trash"></i>',
              '</button>',
            ];
          }

          let botoes = "";

          botoes += editButton;
          botoes += deleteButton.join('');

          return '<div style="white-space: nowrap">' + botoes + '</div>';
        },

        'queryParamsTesteList': function (params) {
          params.filters = {};
          params.filters.filtro = $('#busca').val();

          return params;
        },
      }
    }
  }
};

Teste.index.initDataTable();

$(document).ready(function () {
  $(function () {
    Teste.index.init();
  })
});