/**
 * Carrega as máscaras dos formulários
 */
function carregarMascaras() {
    //Money
    $('.money').priceFormat({
        prefix: 'R$ ',
        centsSeparator: ',',
        thousandsSeparator: '.'
    });

    //Telefone
    $('.inputTel').mask("(99) 9999-9999?9").ready(function(event) {
        var target, phone, element;
        target = (event.currentTarget) ? event.currentTarget : event.srcElement;
        if (target) {
            phone = target.value.replace(/\D/g, '');
            element = $(target);
            element.unmask();
            if (phone.length > 10) {
                element.mask("(99) 99999-999?9");
            } else {
                element.mask("(99) 9999-9999?9");
            }
        }
    });

    //Data
    $('.datepicker').datepicker({
        format: "dd/mm/yyyy",
        language: "pt-BR",
        showOn: "button",
        buttonImage: "/img/calendar.png",
        buttonImageOnly: true
    });
    $('.datepicker').keyup(function() {
        $(this).val("");
    });
    //Atribui o evento ao campos da data
    $('.datepicker')
            .click(function() {
        $(this).parent().find(".ui-datepicker-trigger").click();
    });
}

/**
 * Carrega as notificações do sistema
 * Tipos de mensagens
 *  success
 *  error
 *  warning
 *  information
 *  confirm
 */
function setNotification(msg, type) {
    if (!type) {
        type = 'information';
    }

    noty({
        text: "<b>"+msg+"</b>",
        type: type,
        timeout: 7000
    });
}

/**
 * Compara se a data final é maior que a inicial
 */
function validarPeriodo(queryInicio, queryFinal) {
    if (queryInicio.val() == '' || queryFinal == '') {
        return false;
    }

    var arrInicio = queryInicio.val().split("/");
    var arrFim = queryFinal.val().split("/");
    var dtInvertInicio = arrInicio[2] + arrInicio[1] + arrInicio[0];
    var dtInvertFim = arrFim[2] + arrFim[1] + arrFim[0];

    if (parseInt(dtInvertInicio) > parseInt(dtInvertFim)) {
        return false;
    } else {
        return true;
    }
}

/**
 * Bloqueia a tela durante a execução de um ajax
 */
barNot = null;
function aguarde(hide) {
    if( !hide ) {
        barNot = noty({
                text: "<b>Aguarde...</b>",
                type: 'information',
                layout: 'center'
            });
    } else {
        barNot.close();
    }
}