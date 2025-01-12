node
{
    //Clean LocalRepo
    sh 'rm -rf Lexicon'

    //Pull
    sh 'git clone https://github.com/YousefNass/Lexicon'

    //CheckDirectory
    sh 'ls -la Lexicon'

    //Clean and Build
    sh 'docker compose down && docker compose up -d'
}
