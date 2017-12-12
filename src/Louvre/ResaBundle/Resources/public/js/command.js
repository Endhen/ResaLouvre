
var ReducedElt = document.body.getElementsByClassName('reduced'),
    infoElt =  document.getElementById('info');

for (let box of ReducedElt) {

    box.addEventListener('change', function() {
        for (let input of ReducedElt) 
        {
            if (input.checked) {
                infoElt.style.display = 'block';
                return;
            }
        }
        infoElt.style.display = 'none';
        return;
    });
}



