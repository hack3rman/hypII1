let sel = `<label id = "fix_1">* FROM elevi WHERE</label>
<input id="var_1" type="text" name="var_1" placeholder="[coloană]">
<label id = "fix_2">=</label>
<input id="var_2" type="text" name="var_2" placeholder="[valoare]">
<input type="submit" value="APASĂ">`;

let ins = `<label id = "fix_1">INTO elevi (nume, prenume, vârstă) VALUES</label>
<input id="var_1" type="text" name="var_1" placeholder="Nume">
<input id="var_2" type="text" name="var_2" placeholder="Prenume">
<input id="var_3" type="text" name="var_3" placeholder="Vârstă">
<input type="submit" value="APASĂ">`;

let del = `<label id = "fix_1"> FROM elevi WHERE</label>
<input id="var_1" type="text" name="var_1" placeholder="coloană">
<label id = "fix_2">=</label>
<input id="var_2" type="text" name="var_2" placeholder="valoare">
<input type="submit" value="APASĂ">`;

function schimbă_sintaxa_sql(){
  var selecție = document.getElementById("selecție").selectedIndex;
  console.log(selecție);
  switch (selecție){
    case 0:
      document.getElementById('query').innerHTML = sel;
      break;
    case 1:
      console.log(5);
      document.getElementById('query').innerHTML = ins;
      break;
    case 2:
      document.getElementById('query').innerHTML = del;
      break;
  }
}