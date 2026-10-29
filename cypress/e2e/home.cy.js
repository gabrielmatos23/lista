describe('Página inicial e navegação', () => {
  beforeEach(() => cy.visit('/'))

  it('exibe o nome Doce Gestão', () => {
    cy.contains('Doce Gestão').should('be.visible')
  })

  it('navega pelos módulos principais', () => {
    const links = [
      ['[data-cy="nav-products"]', '/products'],
      ['[data-cy="nav-clients"]', '/clients'],
      ['[data-cy="nav-orders"]', '/orders'],
      ['[data-cy="nav-freights"]', '/freights'],
    ]

    links.forEach(([selector, route]) => {
      cy.get(selector).click()
      cy.url().should('include', route)
      cy.visit('/')
    })
  })
})
