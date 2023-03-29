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
    return `
        <label for="amount" class="form-label">Monto que necesitas</label>
        <input type="range" class="form-range" min="${ product.min_amount }" max="${product.max_amount}" step="${product.step_amount}" id="amount" value="${ product.default_amount }">
    `;
}

function printTerm(product)
{    
    return `
        <label for="term" class="form-label">Plazos</label>
        <input type="range" class="form-range" min="${ product.min_term }" max="${product.max_term}" step="1" id="term" value="${ product.default_term }">
    `;
}

function printAllowedTermTypes(product)
{
    let string= "";
    let array1 = product.allowed_term_type;
    console.log(array1);
    /*array1.foreach((value, index, array)=>{

        string+= `
            <input type="radio" class="btn-check" name="termTypes" id="${ value._id }" autocomplete="off"></input>
            <label class="btn btn-primary" for="${ value._id }">${ value.value }</label>
        `;
    });*/
    return string;
}

function calculate()
{
    let amount = document.getElementById("amount");
    let term = document.getElementById("term");

    //alert(amount.value);
    console.log([amount.value, term.value]);
}
