import MaskBehaviors from './masks-behaviors'

$(function() {
    $('.mask-cellphone').mask(MaskBehaviors.nineDigitsBehavior, MaskBehaviors.nineDigitsOptions);
    $('.mask-money').mask("#.##0,00", {reverse: true});

    $('.mask-phone').mask('(00) 00000-0000');

    $(".mask-cep").mask('00000-000', {
        clearIfNotMatch: true
    });

    $(".mask-cpf").mask('000.000.000-00', {
        reverse: false,
        clearIfNotMatch: true
    });

    $(".mask-cnpj").mask('00.000.000/0000-00', {
        reverse: false,
        clearIfNotMatch: true
    });

    $('.mask-datetime').mask('00/00/0000 00:00', {
        clearIfNotMatch: true
    });

    $('.mask-date').mask('00/00/0000', {
        clearIfNotMatch: true
    });

    $(".mask-weight").mask('#.##0,00', {
        reverse: true,
    });
});
