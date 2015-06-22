/*!
 * FileInput Spanish (Latin American) Translations
 *
 * This file must be loaded after 'fileinput.js'. Patterns in braces '{}', or
 * any HTML markup tags in the messages must not be converted or translated.
 *
 * @see http://github.com/kartik-v/bootstrap-fileinput
 *
 * NOTE: this file must be saved in UTF-8 encoding.
 */
(function ($) {
    "use strict";

    $.fn.fileinput.locales.es = {
        fileSingle: 'arquivo',
        filePlural: 'arquivos',
        browseLabel: 'Buscar &hellip;',
        removeLabel: 'Remover',
        removeTitle: 'Remover arquivos selecionados',
        cancelLabel: 'Cancelar',
        cancelTitle: 'Cancelar o carregamento atual',
        uploadLabel: 'Enviar arquivo',
        uploadTitle: 'Enviar arquivos selecionados',
        msgSizeTooLarge: 'Arquivo "{name}" (<b>{size} KB</b>) excede o tamanho máximo permitido de <b>{maxSize} KB</b>. Por favor tente novamente!',
        msgFilesTooLess: 'Você deve selecionar no mínimo <b>{n}</b> {files} para enviar. Por favor tente novamente!',
        msgFilesTooMany: 'O número de arquivos selecionandos a enviar <b>({n})</b> excede o limite máximo permitido de <b>{m}</b>. Por favor tente novamente!',
        msgFileNotFound: 'Arquivo "{name}" não encontrado!',
        msgFileSecured: 'Restrições de segurança previnem a leitura do arquivo "{name}".',
        msgFileNotReadable: 'Não foi possível ler o arquivo "{name}".',
        msgFilePreviewAborted: 'Previsualización del archivo abortada para "{name}".',
        msgFilePreviewError: 'Ocorreu um erro enquanto o arquivo é lido "{name}".',
        msgInvalidFileType: 'Tipo de arquivo inválido para o arquivo "{name}". Somente arquivos "{types}" são permitidos.',
        msgInvalidFileExtension: 'Extensão de arquivo inválido para "{name}". Somente arquivos "{extensions}" são permitidos.',
        msgValidationError: 'Erro ao carregar arquivo',
        msgLoading: 'Carregando arquivo {index} de {files} &hellip;',
        msgProgress: 'Carregando arquivo {index} de {files} - {name} - {percent}% completado.',
        msgSelected: '{n} arquivos selecionados',
        msgFoldersNotAllowed: 'Arraste e solte únicamente arquivos! {n} pastas serão omitida(s).',
        dropZoneTitle: 'Arraste e solte as imagens aqui &hellip;'
    };

    $.extend($.fn.fileinput.defaults, $.fn.fileinput.locales.es);
})(window.jQuery);