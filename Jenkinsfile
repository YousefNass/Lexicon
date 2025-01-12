node
{
    //Clean LocalRepo
    sh 'rm -rf Lexicon'

    //Pull
    sh 'git clone https://github.com/YousefNass/Lexicon.git'

    //CheckDirectory
    sh 'ls -la Lexicon'

    //Clean and Build
    sh 'cd Lexicon && docker compose down && docker compose up -d'
}
