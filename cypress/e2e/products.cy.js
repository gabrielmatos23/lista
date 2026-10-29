describe('Produtos', () => {
  beforeEach(() => cy.visit('/products'))

  it('mostra a tabela, os cabeçalhos e produtos cadastrados', () => {
    cy.get('[data-cy="product-table"]').should('be.visible')
    cy.get('[data-cy="product-row"]').should('have.length.at.least', 1)
    ;['Nome', 'Categoria', 'Preço', 'Estoque'].forEach((title) => cy.contains('th', title).should('be.visible'))
  })

  it('abre o formulário de cadastro', () => {
    cy.get('[data-cy="create-product"]').click()
    cy.url().should('include', '/products/create')
    cy.get('[data-cy="product-name"]').should('be.visible')
    cy.get('[data-cy="product-category"]').should('be.visible')
    cy.get('[data-cy="product-price"]').should('be.visible')
    cy.get('[data-cy="product-stock"]').should('be.visible')
    cy.get('[data-cy="product-minimum-stock"]').should('be.visible')
  })

  it('cadastra dados de uma fixture', () => {
    cy.fixture('produto').then((product) => {
      product.name += ` ${Date.now()}`
      cy.criarProduto(product)
      cy.contains('[data-cy="product-row"]', product.name).should('be.visible')
    })
  })

  it('exibe os erros ao enviar o formulário vazio', () => {
    cy.visit('/products/create')
    cy.get('[data-cy="product-form"] input, [data-cy="product-form"] select').invoke('removeAttr', 'required')
    cy.get('[data-cy="save-product"]').click()
    cy.get('[data-cy="form-errors"]').should('be.visible')
    cy.get('#name').parent().should('contain.text', 'obrigatório')
  })

  it('rejeita preço negativo', () => {
    cy.visit('/products/create')
    cy.get('[data-cy="product-name"]').type('Preço inválido')
    cy.get('[data-cy="product-category"]').select('Bolos')
    cy.get('[data-cy="product-price"]').invoke('removeAttr', 'min').clear().type('-2')
    cy.get('[data-cy="product-stock"]').type('5')
    cy.get('[data-cy="product-minimum-stock"]').type('1')
    cy.get('[data-cy="save-product"]').click()
    cy.get('[data-cy="form-errors"]').should('be.visible')
  })

  it('rejeita texto no campo de preço', () => {
    cy.visit('/products/create')
    cy.get('[data-cy="product-name"]').type('Preço em texto')
    cy.get('[data-cy="product-category"]').select('Bolos')
    cy.get('[data-cy="product-price"]').invoke('attr', 'type', 'text').type('abc')
    cy.get('[data-cy="product-stock"]').type('5')
    cy.get('[data-cy="product-minimum-stock"]').type('1')
    cy.get('[data-cy="save-product"]').click()
    cy.get('[data-cy="form-errors"]').should('be.visible')
  })

  it('rejeita estoque negativo', () => {
    cy.visit('/products/create')
    cy.get('[data-cy="product-name"]').type('Estoque inválido')
    cy.get('[data-cy="product-category"]').select('Bolos')
    cy.get('[data-cy="product-price"]').type('10')
    cy.get('[data-cy="product-stock"]').invoke('removeAttr', 'min').clear().type('-3')
    cy.get('[data-cy="product-minimum-stock"]').type('1')
    cy.get('[data-cy="save-product"]').click()
    cy.get('[data-cy="form-errors"]').should('be.visible')
  })

  it('edita o preço de um produto', () => {
    const product = { name: `Produto edição ${Date.now()}`, category: 'Doces', price: 10, stock: 7, minimum_stock: 2 }
    cy.criarProduto(product)
    cy.contains('[data-cy="product-row"]', product.name).find('[data-cy="edit-product"]').click()
    cy.get('[data-cy="product-price"]').clear().type('15.50')
    cy.get('[data-cy="save-product"]').click()
    cy.contains('[data-cy="product-row"]', product.name).should('contain.text', '15,50')
  })

  it('exclui um produto de teste', () => {
    const product = { name: `Produto excluir ${Date.now()}`, category: 'Doces', price: 10, stock: 7, minimum_stock: 2 }
    cy.criarProduto(product)
    cy.on('window:confirm', () => true)
    cy.contains('[data-cy="product-row"]', product.name).find('[data-cy="delete-product"]').click()
    cy.contains('[data-cy="product-row"]', product.name).should('not.exist')
  })

  it('marca estoque baixo e deixa estoque acima do mínimo sem alerta', () => {
    const low = { name: `Estoque baixo ${Date.now()}`, category: 'Bolos', price: 20, stock: 2, minimum_stock: 5 }
    cy.criarProduto(low)
    cy.contains('[data-cy="product-row"]', low.name).find('.badge.low').should('be.visible')
    const regular = { ...low, name: `Estoque normal ${Date.now()}`, stock: 8 }
    cy.criarProduto(regular)
    cy.contains('[data-cy="product-row"]', regular.name).find('.badge.low').should('not.exist')
  })

  it('permite avançar e voltar na paginação', () => {
    cy.get('[data-cy="product-row"]').first().invoke('text').then((firstPage) => {
      cy.get('a[rel="next"]:visible').first().click()
      cy.get('[data-cy="product-row"]').first().invoke('text').should('not.equal', firstPage)
      cy.get('a[rel="prev"]:visible').first().click()
      cy.get('[data-cy="product-row"]').first().invoke('text').should('equal', firstPage)
    })
  })
})
