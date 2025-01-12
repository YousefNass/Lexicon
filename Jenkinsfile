node
{
    //Clean Repo
    sh 'rm Lexicon'
    //Pull
    sh 'git clone https://github.com/YousefNass/Lexicon.git && cd Lexicon && git pull origin main'
    //Clean
    sh 'docker compose down'
    
    //Build
    sh 'docker compose up -d'
}
