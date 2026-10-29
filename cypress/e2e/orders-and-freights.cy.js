describe('Pedidos e fretes', () => {
  it('cria cliente, produto e pedido e confere a baixa automática no estoque', () => {
    const suffix = Date.now()
    const product = { name: `Bolo do pedido ${suffix}`, category: 'Bolos', price: 24, stock: 10, minimum_stock: 2 }
    const client = { name: `Cliente do pedido ${suffix}`, email: `pedido-${suffix}@example.test`, phone: '11999990000', address: 'Rua das Flores, 10' }

    cy.criarProduto(product)
    cy.criarCliente(client)
    cy.visit('/products')
    cy.contains('[data-cy="product-row"]', product.name).should('contain.text', '10 un.')
    cy.intercept('POST', '/orders').as('createOrder')
    cy.visit('/orders/create')
    cy.get('[data-cy="order-client"]').select(client.name)
    cy.get('[data-cy="order-product"] option').contains(product.name).invoke('val').then((id) => {
      cy.get('[data-cy="order-product"]').select(id)
    })
    cy.get('[data-cy="order-quantity"]').clear().type('3')
    cy.get('[data-cy="save-order"]').click()
    cy.wait('@createOrder').its('response.statusCode').should('eq', 302)
    cy.contains('[data-cy="order-row"]', product.name).should('contain.text', 'Recebido')
    cy.visit('/products')
    cy.contains('[data-cy="product-row"]', product.name).should('contain.text', '7 un.')
  })

  it('recusa pedido com quantidade acima do estoque', () => {
    const suffix = Date.now()
    const product = { name: `Pouco estoque ${suffix}`, category: 'Doces', price: 8, stock: 2, minimum_stock: 1 }
    const client = { name: `Cliente estoque ${suffix}`, email: `estoque-${suffix}@example.test` }
    cy.criarProduto(product)
    cy.criarCliente(client)
    cy.visit('/orders/create')
    cy.get('[data-cy="order-client"]').select(client.name)
    cy.get('[data-cy="order-product"] option').contains(product.name).invoke('val').then((id) => {
      cy.get('[data-cy="order-product"]').select(id)
    })
    cy.get('[data-cy="order-quantity"]').clear().type('3')
    cy.get('[data-cy="save-order"]').click()
    cy.get('[data-cy="form-errors"]').should('be.visible')
    cy.get('#quantity').parent().should('contain.text', 'Estoque insuficiente')
  })

  it('cadastra um frete e acompanha as etapas até a entrega', () => {
    const suffix = Date.now()
    const product = { name: `Produto frete ${suffix}`, category: 'Bolos', price: 18, stock: 6, minimum_stock: 1 }
    const client = { name: `Cliente frete ${suffix}`, email: `frete-${suffix}@example.test` }
    cy.criarProduto(product)
    cy.criarCliente(client)
    cy.visit('/orders/create')
    cy.get('[data-cy="order-client"]').select(client.name)
    cy.get('[data-cy="order-product"] option').contains(product.name).invoke('val').then((id) => {
      cy.get('[data-cy="order-product"]').select(id)
    })
    cy.get('[data-cy="order-quantity"]').clear().type('1')
    cy.get('[data-cy="save-order"]').click()
    cy.visit('/orders')
    cy.contains('[data-cy="order-row"]', product.name).invoke('text').then((row) => {
      const orderNumber = row.match(/#(\d+)/)[1]
      cy.visit('/freights/create')
      cy.get('[data-cy="freight-order"]').select(orderNumber)
      cy.get('[data-cy="freight-address"]').type('Rua das Flores, 120')
      cy.get('[data-cy="freight-fee"]').type('12.50')
      cy.get('[data-cy="freight-date"]').type('2030-12-20')
      cy.get('[data-cy="freight-tracking"]').type(`RASTREIO${suffix}`)
      cy.get('[data-cy="freight-status"]').select('Preparando')
      cy.get('[data-cy="save-freight"]').click()
      cy.contains('[data-cy="freight-row"]', 'Preparando').should('be.visible')
      ;['Enviado', 'Em trânsito', 'Entregue'].forEach((status) => {
        cy.contains('[data-cy="freight-row"]', 'RASTREIO').find('a').click()
        cy.get('[data-cy="freight-status"]').select(status)
        cy.get('[data-cy="save-freight"]').click()
        cy.contains('[data-cy="freight-row"]', status).should('be.visible')
      })
    })
  })
})
