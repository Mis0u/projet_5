 class Anecdote
{
    constructor()
    {
        this.url = "https://bridge.buddyweb.fr/api/anecuniv/anecdotesspatiales";
        this.getAnecdote(this.url)
        this.anecdote = document.getElementById("anecdotes")
    }
    
    async getAnecdote(url){
        const anecdoteFetch =  await fetch(url)
            .then(reponse => reponse.json())
            .then(reponseJson => reponseJson)
            this.displayAnecdote(anecdoteFetch)
    } 

    displayAnecdote(data){
        let randomAnecdote = Math.round(Math.random() * 60);
        const anecdote = data[randomAnecdote].content;
        this.anecdote.textContent = anecdote
    } 

   
} 
