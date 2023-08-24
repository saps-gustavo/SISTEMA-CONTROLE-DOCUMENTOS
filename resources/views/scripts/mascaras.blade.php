<script src="/assets/js/jquery.mask.min.js"></script>

<script>
    
    $('.telefone-ddd').mask('00');
    $('.telefone-num').mask('0000-0000');
    $('.telefone-dd-num').mask('(00)0000-0000');
    $('.celular-dd-num').mask('(00)00000-0000');
    $('.hora').mask('00:00');
    $('.cep').mask('00000-000'); 
    $('.ano').mask('0000');
    $('.num-processo').mask('99999/99');
    $('.num-proximo').mask('999');
    $('.vol-processo').mask('99')
    $('.num-peticao').mask('999999');
    $('.data').mask('00/00/0000');
    $('.num-dam').mask('00/000000-0');
    $('.money').mask('000000000000.00', {reverse: true});
    $('.coordenadas').mask('00.000000', {reverse: true});
    $('.conta_bancaria').mask('00000000000-0', {reverse: true});
    $('.agencia_bancaria').mask('00000000-0', {reverse: true});
    $('.processo').mask('00000000000/0000', {reverse: true});
    $('.money_br').mask('000.000.000.000,00', {reverse: true});
    $('.somente_numero').mask('99999');
    $('.somente_tipos_adm').mask('999');
    $('.numero-contrato').mask('0000.000-00/0000', {reverse: true});
    $('.licitacao-referencia-preco').mask('00/0000', {reverse: true});
    $('.numero-contrato-obra').mask('00.0000.000', {reverse: true});
    $('.referencia-sisop').mask('99999999999999999999');
    $('.porcentagem').mask('Z99,99', {
        translation: {
            'Z': {
            pattern: /[\-\+]/,
            optional: true
            }
        }
    });
    $('.numero-empenho').mask('0000NE00000', {reverse: true});
    $('.numero-ordem-bancaria').mask('0000OB00000', {reverse: true});
    $('.mes-ano').mask('00/0000', {reverse: true});
    $('.numero-modalidade').mask('00000/0000', {reverse: true});
    $('.money_br_negativo').mask('000.000.000.000,00', {
        reverse: true,
        translation: { 
            '0': {
                pattern: /-|\d/,
                recursive: true
            }
        },
        onChange: function(value, e) {
            e.target.value = value.replace('-.', '-');
        }
    });
    $('.cnpj').mask('99.999.999/9999-99');
    $('.cpf').mask('999.999.999-99');

    var options = {
        onKeyPress: function (cpf, ev, el, op) {
            var masks = ['000.000.000-00', '00.000.000/0000-00'];
            $('.cpfOuCnpj').mask((cpf.length > 14) ? masks[1] : masks[0], op);
        }
    }

    $('.cpfOuCnpj').length > 11 ? $('.cpfOuCnpj').mask('00.000.000/0000-00', options) : $('.cpfOuCnpj').mask('000.000.000-00#', options);

    $('.numero-cad-unico').mask('00000000000', {reverse: true});
    
 </script>