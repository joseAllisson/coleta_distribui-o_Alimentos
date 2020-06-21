function cpf(cpf) {

    cpf = cpf.replace(/\D/g, '');
    if (cpf.toString().length != 11 || /^(\d)\1{10}$/.test(cpf)) return false;
    var result = true;
    [9, 10].forEach(function (j) {
        var soma = 0, r;
        cpf.split(/(?=)/).splice(0, j).forEach(function (e, i) {
            soma += parseInt(e) * ((j + 2) - (i + 1));
        });
        r = soma % 11;
        r = (r < 2) ? 0 : 11 - r;
        if (r != cpf.substring(j, j + 1)) result = false;
    });
    return result;
}
// Chamadas de validaçao, com teclas
document.getElementById('cpf').addEventListener('keyup', testeRapido, false);

function valida() {
    var inputCpf = document.getElementById('cpf').value;

    teste = cpf(inputCpf);
    if (teste) {
        document.getElementById('invalid').style = "display: none";
        document.getElementById('cpf').style = "border: 1px solid #20B2AA!important;";
        
        return true
    }
    else {
        document.getElementById('cpf').style = "border: 1px solid red!important;";
        document.getElementById('cpf').focus();
        document.getElementById('invalid').style = "display: block";

        return false
    }
}

function testeRapido() {
    var delay = 1000;

    setTimeout(valida(), delay);
    setTimeout(validaCadastro(), delay);
}


