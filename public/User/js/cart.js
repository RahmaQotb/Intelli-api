

$( document ).ready(function() {
    let cards = document.querySelectorAll('.addCartBtn');
    
    cards.forEach(element => {
        element.addEventListener('click',(e)=>{
            cartId = e.target.value;
            
            axios.post(`addToCart/${cartId}`)
            .then(response =>{
                toastr.success(response.data.message)
            },

            (reason) => {
                if(reason.response.status == '401'){
                    toastr.error('Please Login First')
                }
            },
        );
    
            
        })
    });
});