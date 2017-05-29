function validarCPF(strCPF){
	var Soma;
    var Resto;
	
	strCPF = strCPF.replace('.', '');
	strCPF = strCPF.replace('.', '');
	strCPF = strCPF.replace('.', '');
	strCPF = strCPF.replace('-', '');
	
    Soma = 0;
	if (strCPF == "00000000000") return false;
	if (strCPF == "11111111111") return false;
	if (strCPF == "22222222222") return false;
	if (strCPF == "33333333333") return false;
	if (strCPF == "44444444444") return false;
	if (strCPF == "55555555555") return false;
	if (strCPF == "66666666666") return false;
	if (strCPF == "77777777777") return false;
	if (strCPF == "88888888888") return false;
	if (strCPF == "99999999999") return false;
    
	for (i=1; i<=9; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
	Resto = (Soma * 10) % 11;
	
    if ((Resto == 10) || (Resto == 11))  Resto = 0;
    if (Resto != parseInt(strCPF.substring(9, 10)) ) return false;
	
	Soma = 0;
    for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
    Resto = (Soma * 10) % 11;
	
    if ((Resto == 10) || (Resto == 11))  Resto = 0;
    if (Resto != parseInt(strCPF.substring(10, 11) ) ) return false;
    return true;
}

function checkData(data){
	var nvdata = data.split("/");
	
	if(nvdata.length == 3){
		var dia = nvdata[0];
		var mes = nvdata[1];
		var ano = nvdata[2];
		
		
		if ((mes == 4 || mes == 6 || mes == 9 || mes == 11) && dia > 30) {
			return false;
		}else if((mes == 1 || mes == 3 || mes == 5 || mes == 7 || mes == 8 || mes == 10 || mes == 12) && dia > 31){
			return false;
		}else {
			if ((ano % 4) != 0 && mes == 2 && dia > 28) 
				return false;
			else
				if ((ano%4) == 0 && mes == 2 && dia > 29)
					return false;
	  
		}
		
	}else{
		return false;
	}
	
	return true;
}