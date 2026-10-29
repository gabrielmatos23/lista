const { defineConfig } = require('cypress')
const { execFileSync } = require('node:child_process')

function resetDatabase() {
  const useDocker = process.env.CYPRESS_DOCKER === '1'
  const command = useDocker ? 'docker' : 'php'
  const args = useDocker
    ? ['compose', 'exec', '-T', 'app', 'php', 'artisan', 'migrate:fresh', '--seed']
    : ['artisan', 'migrate:fresh', '--seed']

  execFileSync(command, args, { cwd: __dirname, stdio: 'inherit' })
  return null
}

module.exports = defineConfig({
  e2e: {
    baseUrl: 'http://localhost:8000',
    supportFile: 'cypress/support/e2e.js',
    setupNodeEvents(on) {
      on('before:run', resetDatabase)
      on('task', { 'db:fresh:seed': resetDatabase })
    },
  },
})
