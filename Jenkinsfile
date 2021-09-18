pipeline {
    agent any
    stages {
        stage('build') {
            steps {
                sh '''
                docker-compose up -d 
                docker-compose exec -T php-diy sh -c  "/composer.phar install"
                '''            
            }
        }

        stage('test') {
            steps {
                sh '''
                docker-compose exec -T php-diy sh -c "php ./bin/phpunit" 
                '''            
            }
        }

        stage('checkout')  {
            steps {
               step([
                    $class:'CloverPublisher',
                    cloverReportDir: 'phpunit-report',
                    cloverReportFileName: 'clover.xml',
                    healthyTarget: [methodCoverage: 70, conditionalCoverage: 70, statementCoverage: 70],
                    unhealthyTarget: [methodCoverage: 50, conditionalCoverage: 50, statementCoverage: 50],
                    failingTarget: [methodCoverage: 0, conditionalCoverage: 0, statementCoverage: 0]
                ])
            publishHTML (target : [allowMissing: false,
                    alwaysLinkToLastBuild: true,
                    keepAll: true,
                    reportDir: 'phpunit-report/html-coverage',
                    reportFiles: 'index.html',
                    reportName: 'My Reports',
                    reportTitles: 'The Report'])
            }
        }        
    
    }
    post {
        always {
        junit '**/phpunit-report/junit.xml'
        }
    }

}