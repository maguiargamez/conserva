var data= {};
function loadData(value)
{
    data= value;
    console.log(data);
}

function showData(idProduct)
{
    console.log(data[idProduct]);
    let product= data[idProduct];
    let string= "";
    const divData= document.getElementById("data");

    string+= printAmount(product);
    string+= printTerm(product);
    string+= printAllowedTermTypes(product);
    divData.innerHTML= string;
    
}

function printAmount(product)
{    
    const formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'MXN',
      });
    return `
        <div class="mb-3">
            <label for="amount" class="form-label">Monto que necesitas: $ <span id="lblAmount">${ formatter.format(product.default_amount) }</span></label>
            <input type="range" onChange="document.getElementById('lblAmount').innerHTML = formatter.format(this.value)" class="form-range" min="${ product.min_amount }" max="${product.max_amount}" step="${product.step_amount}" id="amount" value="${ product.default_amount }">
        </div>
    `;
}

function printTerm(product)
{    
    return `
        <div class="mb-3">
            <label for="term" class="form-label">Plazos: <span id="lblTerm">${ product.default_term }</span> semanas</label>
            <input type="range" onChange="document.getElementById('lblTerm').innerHTML = this.value" class="form-range" min="${ product.min_term }" max="${product.max_term}" step="1" id="term" value="${ product.default_term }">
        </div>
    `;
}

function printAllowedTermTypes(product)
{
    let string= `<div class="mb-3">
                    <label for="termTypes" class="form-label">Pagos</label>
                </div>
                `;
    let array1 = product.allowed_term_type;
    for (let i= 0; i < array1.length; i++) {
        string+= `
            <input type="radio" class="btn-check" name="termTypes" id="${ array1[i]._id }" autocomplete="off"></input>
            <label class="btn btn-primary" for="${ array1[i]._id }">${ array1[i].value }</label>
        `;
    }
    return string;
}

function calculate()
{
    let amount = document.getElementById("amount");
    let term = document.getElementById("term");
    //alert(amount.value);
    console.log([amount.value, term.value]);
}
