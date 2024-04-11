export class ApiError extends Error {
  constructor(
    public status: number,
    message: string
  ) {
    super(message);
    this.name = "ApiError";
  }

  static async fromResponse(response: Response): Promise<ApiError> {
    const text = await response.clone().text();
    const errMsg: { message?: string } = await response
      .json()
      .catch(() => ({}));

    return new ApiError(response.status, errMsg.message ?? text);
  }
}

declare global {
  class ApiError extends Error {
    constructor(status: number, message: string);
    status: number;
    static fromResponse(response: Response): Promise<ApiError>;
  }
}
