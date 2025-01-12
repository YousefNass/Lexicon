node
{
    //Clean LocalRepo
    sh 'rm -rf Lexicon'

    //Pull
    sh 'git clone https://github.com/YousefNass/Lexicon.git && cd Lexicon'

    //CheckDirectory
    sh 'ls -la Lexicon'

    //Build
    sh 'docker compose up -d docker-compose.yml'
}
