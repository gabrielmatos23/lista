describe('Clientes', () => {
  beforeEach(() => cy.visit('/clients'))

  it('cria, edita e exclui um cliente usando a fixture', () => {
    cy.fixture('cliente').then((client) => {
      client.name += ` ${Date.now()}`
      client.email = `cliente-${Date.now()}@example.test`
      cy.criarCliente(client)
      cy.contains('[data-cy="client-row"]', client.name).should('contain.text', client.email)
      cy.contains('[data-cy="client-row"]', client.name).find('a').click()
      cy.get('[data-cy="client-name"]').clear().type(`${client.name} atualizado`)
      cy.get('[data-cy="save-client"]').click()
      cy.contains('[data-cy="client-row"]', `${client.name} atualizado`).should('be.visible')
      cy.on('window:confirm', () => true)
      cy.contains('[data-cy="client-row"]', `${client.name} atualizado`).find('button').click()
      cy.contains('[data-cy="client-row"]', `${client.name} atualizado`).should('not.exist')
    })
  })
})
