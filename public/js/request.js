const request = async (url, method = 'GET', data = null, headers = {}) => {
    const options = {
        method
    };

    if (data) {
        options.body = JSON.stringify(data);
    }

    options.headers = headers;

    const response = await fetch(url, options);

    if (response.status === 401) {
        throw new Error('Você não está autenticado');
    }

    if (response.status === 403) {
        throw new Error('Você não tem permissão para acessar este recurso');
    }

    if (response.status === 404) {
        throw new Error('Recurso não encontrado');
    }

    if (response.status === 419) {
        throw new Error('Recarregue a página para continuar');
    }

    if (response.status === 500) {
        throw new Error('Erro interno do servidor');
    }

    if (response.status === 503) {
        throw new Error('Serviço temporariamente indisponível');
    }
    
    if (response.status === 504) {
        throw new Error('Tempo limite de conexão excedido');
    }

    return response;
}