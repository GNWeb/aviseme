/**
 * Carrega as máscaras dos formulários
 */
function carregarMascaras() {
    //Money
     $('.money').mask('000.000.000.000.000,00', {reverse: true});
     
    //Telefone
    if ($(".inputTel").length > 0) {
        $(".inputTel").each(function() {
            $(this).keyup(function(event) {
                var novoValor = $(this).val();
                novoValor = novoValor.replace("(", "");
                novoValor = novoValor.replace(")", "");
                novoValor = novoValor.replace("-", "");
                var valorNumerico = parseInt(novoValor).toString();
                novoValor = parseInt(novoValor).toString();

                //(DDD)
                if(valorNumerico.toString().length > 1) {
                    novoValor = '(' + valorNumerico.substr(0, 2) + ")";
                }
                //9999-999
                if(valorNumerico.toString().length > 6 && valorNumerico.toString().length < 11) {
                    novoValor += valorNumerico.substr(2,4);
                    novoValor += "-";
                    novoValor += valorNumerico.substr(6);
                } else if(valorNumerico.toString().length >= 11) { 
                    novoValor += valorNumerico.substr(2, 5);
                    novoValor += "-";
                    novoValor += valorNumerico.substr(7, 4);
                } else {
                    novoValor += valorNumerico.substr(2);
                }
                
                if (novoValor == 'NaN' || novoValor == '(Na)N') {
                    novoValor = '';
                }
                
                $(this).val(novoValor);
                
                return false;
            });
        });
    }
    
    //Data
    $('.datepicker').datepicker({
        format: "dd/mm/yyyy",
        language: "pt-BR",
        showOn: "button",
        buttonImage: "/img/calendar.png",
        buttonImageOnly: true
    });
}