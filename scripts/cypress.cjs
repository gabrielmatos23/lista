const { spawnSync } = require('node:child_process')
const path = require('node:path')

const command = process.argv[2]
if (!['open', 'run'].includes(command)) {
  console.error('Use: npm run cy:open ou npm run cy:run')
  process.exit(2)
}

// Algumas integrações Electron definem esta variável e impedem o Cypress de abrir.
delete process.env.ELECTRON_RUN_AS_NODE

const executable = path.join(__dirname, '..', 'node_modules', 'cypress', 'bin', 'cypress')
const result = spawnSync(process.execPath, [executable, command], {
  cwd: path.join(__dirname, '..'),
  env: process.env,
  stdio: 'inherit',
})

if (result.error) {
  console.error(result.error)
  process.exit(1)
}
process.exit(result.status ?? 1)
