import { test } from '@japa/runner'

test.group('Users', () => {
  test('get the list of users', async ({client}) => {
    const response = await client.get('/users')

    response.assertStatus(404)
  })
})
