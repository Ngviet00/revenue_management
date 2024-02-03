using System.ComponentModel.DataAnnotations;

namespace RevenueManagement.Models.Requests.User
{
    public class ChangePasswordRequest
    {
        [Required(ErrorMessage = "Mật khẩu hiện tại không được để trống!")]
        [MinLength(6, ErrorMessage = "Mật khẩu hiện tại phải có ít nhất 6 ký tự!")]
        public string CurrentPassword { get; set; } = string.Empty;

        [Required(ErrorMessage = "Mật khẩu mới không được để trống!")]
        [MinLength(6, ErrorMessage = "Mật khẩu mới phải có ít nhất 6 ký tự!")]
        public string NewPassword { get; set; } = string.Empty;

        [Required(ErrorMessage = "Xác nhận mật khẩu không được để trống!")]
        [Compare("NewPassword", ErrorMessage = "Mật khẩu mới và xác nhận mật khẩu không giống nhau!")]
        [MinLength(6, ErrorMessage = "Xác nhận mật khẩu mới phải có ít nhất 6 ký tự!")]
        public string ConfirmNewPassword { get; set; } = string.Empty;
    }
}
