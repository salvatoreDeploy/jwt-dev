const form = document.querySelector("form");
const btn_check_auth = document.querySelector("#btn_check_auth")

axios.defaults.baseURL = 'http://localhost/jwt-dev/backend/public/';

form.addEventListener('submit', async function(event){
    event.preventDefault()
    
    try{
        const formData = new FormData(event.target);

        const {data} = await axios.post('login.php', formData);
        //console.log(data);

        sessionStorage.setItem('session', data);
    }catch(error){
        console.log(error);
    }
});

btn_check_auth.addEventListener('click', async () => {
    //console.log('auth');
    try{
        const authSession = 'Bearer '+sessionStorage.getItem('session');

        const {data} = await axios.get('auth.php', {
            headers:{
                "Authorization": authSession
            }
        });

        console.log(data);
    }catch(error){
        if(error.response.data === 'Expired token'){
            alert('Sessão Finalizada!');
        }

        console.log(error);
    }
})
